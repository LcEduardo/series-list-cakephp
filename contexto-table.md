# System Context

## Overview
A personal web application for tracking watched TV series. Each user can register series, rate them, and classify them by genre.

---

## Tech Stack

| Component | Technology |
| --------- | ---------- |
| Database  | SQLite     |
| Language  | PhP        |
| Framework | CakePhp    |

---

## Data Model

### Table: `users` — System users
| Column | Type | Constraints | Description |
|---|---|---|---|
| `id` | INTEGER | PK, AUTO INCREMENT | Unique identifier |
| `name` | TEXT | NOT NULL | Full name |
| `age` | INTEGER | — | User's age |
| `email` | TEXT | NOT NULL, UNIQUE | Login email |
| `password` | TEXT | NOT NULL | Password (store as hash) |

---

### Table: `genre` — Available genres
| Column | Type | Constraints | Description |
|---|---|---|---|
| `id` | INTEGER | PK, AUTO INCREMENT | Unique identifier |
| `description` | TEXT | NOT NULL, UNIQUE | Genre name (e.g. "Drama", "Comedy") |

---

### Table: `series` — Series registered by users
| Column             | Type    | Constraints                | Description                |
| ------------------ | ------- | -------------------------- | -------------------------- |
| `id`               | INTEGER | PK, AUTO INCREMENT         | Unique identifier          |
| `user_id`          | INTEGER | FK → `users.id`, NOT NULL  | Record owner               |
| `genre_id`         | INTEGER | FK → `genre.id`, NOT NULL  | Series genre               |
| `title`            | TEXT    | NOT NULL                   | Series title               |
| `watched_episodes` | INTEGER | —                          | Number of episodes watched |
| `qtd_episodes  `     | INTEGER |                            | Total episodes             |
| `rating`           | REAL    | CHECK between 0.0 and 10.0 | User's personal rating     |

---

## Relationships

- One **user** can have many **series** (1:N)
- One **genre** can be associated with many **series** (1:N)
- Each **series** belongs to exactly one user and one genre

---

## Business Rules

1. The `email` must be unique per user.
2. The `rating` must be within the range of **0.0 to 10.0**.
3. Deleting a user must cascade-delete all their series (`ON DELETE CASCADE`).
4. The `watched_episodes` field represents episodes **already watched**, not the total episodes in the series.

---

## Sample Data

**Pre-seeded genres:**
- `Drama`, `Comedy`, `Action`, `Horror`, `Sci-Fi`, `Documentary`

**Example series record:**
```json
{
  "id": 1,
  "user_id": 3,
  "genre_id": 2,
  "title": "Breaking Bad",
  "watched_episodes": 62,
  "rating": 9.8
}
```