# SJT Travel Management System (STMS)

STMS is a premium travel booking and operations platform foundation. Sprint 1 initializes a production-ready frontend, backend placeholder, Docker environment, and project documentation.

## Tech Stack

- **Frontend:** Next.js 15 App Router, React 19, TypeScript strict mode
- **Styling:** Tailwind CSS with Poppins and Inter typography
- **State/Data:** TanStack Query, Zustand, Axios
- **Forms/Validation:** React Hook Form, Zod
- **UI:** Framer Motion, Lucide React, clsx
- **PWA:** next-pwa manifest-ready setup
- **Backend:** Laravel 12 folder placeholder
- **Tooling:** ESLint, Prettier, Husky
- **Infrastructure:** Docker, Docker Compose, MySQL, Redis

## Folder Structure

```text
frontend/
  app/
  components/
  features/
  hooks/
  lib/
  public/
  services/
  styles/
  types/
backend/
  app/
  bootstrap/
  config/
  database/
  public/
  resources/
  routes/
  storage/
  tests/
docs/
docker/
  backend/
  frontend/
```

## Installation

Install frontend dependencies:

```bash
cd frontend
npm install
```

Run the frontend locally:

```bash
npm run dev
```

Run the full Docker environment:

```bash
docker compose up --build
```

Frontend: <http://localhost:3000>  
Backend placeholder service: <http://localhost:8000>  
MySQL: `localhost:3306`  
Redis: `localhost:6379`

## Notes

The backend directory intentionally contains only a Laravel-compatible placeholder structure. Laravel implementation begins in a later sprint.
