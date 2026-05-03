# pq (beta) version 0.7

pq = (php+query & php+quick)

**pq is a small DSL for writing database logic in a more readable way.**

This project is currently in **beta**.
The syntax and behavior may change at any time.

my test page https://pq365.mycafe24.com/intro

---

## ⚠️ Status

* Beta version
* Not stable
* Breaking changes can happen anytime

Use it freely, modify it, break it — no restrictions.

---

## 💡 Concept

pq separates **values** and **objects** explicitly:

* `@value` → raw value
* `(@value)` → object access (methods / properties)

No hidden magic. Everything is explicit.

---

## ✨ Example

```pq
@res = db.users.where("age > 20").get();

foreach(@res as @row):
  print((@row).name);
endforeach;
```

---

## 🧠 Why pq?

Most database code becomes:

* verbose
* hard to read
* mixed with logic and templating

pq tries to make it:

* simple
* readable
* predictable

---

## 🤖 Development

pq is being developed with the help of AI.

Design decisions, structure, and refinements are iterated through human + AI collaboration.

---

## 🔧 Design Philosophy

* Explicit over implicit
* Readability over abstraction
* Minimal syntax, maximum clarity

---

## 🚀 Usage

Use it however you want.

* Personal projects
* Experiments
* Modify freely
* Fork freely

No rules. No constraints.

---

## 📌 Notes

This is a **personal-driven project**.

It is built for real usage first, not for popularity.

If it fits your workflow, use it.
If not, feel free to ignore it.

---

## 🧩 Future

There is no strict roadmap.

pq will evolve based on actual usage and needs.

---

## 🧪 Final

This is beta software.

Expect changes.
Expect rough edges.

And most importantly —
**use it if it helps you.**
