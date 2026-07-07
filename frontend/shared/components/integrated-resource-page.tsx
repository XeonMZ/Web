'use client';

import { useMemo, useState } from 'react';
import { useQuery } from '@tanstack/react-query';
import { RefreshCw } from 'lucide-react';
import { http } from '@/services/http';
import { ActionButton, AppCard, Badge, DataTable, EmptyState, FilterBar, Loading, PageHeader, SearchBar, SectionHeader } from '@/shared/ui/components';
import { PermissionGuard, RoleGuard } from '@/shared/ui/guards/guards';
import type { AppRole } from '@/shared/ui/navigation/types';

export type ResourceColumn = { key: string; label: string };

type IntegratedResourcePageProps = {
  title: string;
  description: string;
  endpoint?: string;
  queryKey: string;
  columns?: ResourceColumn[];
  allowedRoles: AppRole[];
  currentRole: AppRole;
  realtimeTopic?: string;
  todoEndpoint?: string;
};

function getValue(row: Record<string, unknown>, key: string) {
  const value = key.split('.').reduce<unknown>((carry, part) => (carry && typeof carry === 'object' ? (carry as Record<string, unknown>)[part] : undefined), row);
  if (value === null || value === undefined || value === '') return '—';
  if (typeof value === 'object') return JSON.stringify(value);
  return String(value);
}

function normalizeRows(payload: unknown): Record<string, unknown>[] {
  const data = payload && typeof payload === 'object' && 'data' in payload ? (payload as { data: unknown }).data : payload;
  if (Array.isArray(data)) return data.filter((item): item is Record<string, unknown> => Boolean(item) && typeof item === 'object' && !Array.isArray(item));
  if (data && typeof data === 'object') return [data as Record<string, unknown>];
  return [];
}

export function IntegratedResourcePage({ title, description, endpoint, queryKey, columns = [{ key: 'id', label: 'ID' }, { key: 'status', label: 'Status' }, { key: 'created_at', label: 'Created' }], allowedRoles, currentRole, realtimeTopic, todoEndpoint }: IntegratedResourcePageProps) {
  const [search, setSearch] = useState('');
  const [status, setStatus] = useState('all');
  const [sortKey, setSortKey] = useState(columns[0]?.key ?? 'id');
  const [page, setPage] = useState(1);
  const pageSize = 10;
  const hasEndpoint = Boolean(endpoint);
  const query = useQuery({
    queryKey: [queryKey, endpoint],
    enabled: hasEndpoint,
    queryFn: async () => (await http.get(endpoint as string)).data,
  });

  const rows = useMemo(() => {
    const q = search.toLowerCase();
    return normalizeRows(query.data)
      .filter((row) => (status === 'all' ? true : getValue(row, 'status').toLowerCase() === status.toLowerCase()))
      .filter((row) => (q ? JSON.stringify(row).toLowerCase().includes(q) : true))
      .sort((a, b) => getValue(a, sortKey).localeCompare(getValue(b, sortKey)));
  }, [query.data, search, sortKey, status]);

  const statuses = Array.from(new Set(normalizeRows(query.data).map((row) => getValue(row, 'status')).filter((value) => value !== '—')));
  const pagedRows = rows.slice((page - 1) * pageSize, page * pageSize);
  const tableRows = pagedRows.map((row) => columns.map((column) => column.key === 'status' ? <Badge key={column.key}>{getValue(row, column.key)}</Badge> : getValue(row, column.key)));

  return <RoleGuard role={currentRole} allowed={allowedRoles}><PermissionGuard><div className="space-y-6">
    <PageHeader title={title} description={description} actions={<ActionButton onClick={() => query.refetch()} disabled={!hasEndpoint || query.isFetching}><RefreshCw size={16} className={query.isFetching ? 'animate-spin' : ''} /> Refresh</ActionButton>} />
    <FilterBar><div onChange={(event) => setSearch((event.target as HTMLInputElement).value)}><SearchBar placeholder={`Search ${title}`} /></div><select className="rounded-xl border bg-transparent px-3 py-2 text-sm" value={status} onChange={(event) => setStatus(event.target.value)}><option value="all">All statuses</option>{statuses.map((item) => <option key={item} value={item}>{item}</option>)}</select><select className="rounded-xl border bg-transparent px-3 py-2 text-sm" value={sortKey} onChange={(event) => setSortKey(event.target.value)}>{columns.map((column) => <option key={column.key} value={column.key}>Sort by {column.label}</option>)}</select>{realtimeTopic ? <Badge tone="success">Realtime: {realtimeTopic}</Badge> : <Badge>Readonly</Badge>}</FilterBar>
    {!hasEndpoint ? <EmptyState title="Backend endpoint pending" description={todoEndpoint ?? 'Typed readonly TODO interface only; no backend endpoint was created.'} /> : query.isLoading ? <Loading /> : query.isError ? <AppCard><SectionHeader title="Unable to load data" description={(query.error as Error).message} /><ActionButton className="mt-4" onClick={() => query.refetch()}>Retry</ActionButton></AppCard> : rows.length === 0 ? <EmptyState title="No records found" description="Try clearing search or filters, then refresh." /> : <DataTable columns={columns.map((column) => column.label)} rows={tableRows} />}
    <div className="flex items-center justify-between text-sm font-bold"><span>Page {page} • {rows.length} records</span><div className="flex gap-2"><button className="rounded-xl border px-3 py-2" disabled={page === 1} onClick={() => setPage((value) => Math.max(1, value - 1))}>Previous</button><button className="rounded-xl border px-3 py-2" disabled={page * pageSize >= rows.length} onClick={() => setPage((value) => value + 1)}>Next</button></div></div>
  </div></PermissionGuard></RoleGuard>;
}
