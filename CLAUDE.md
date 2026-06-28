# ADW-Elementor — Rules for Claude (read these every session)

> Maintainer: Suhaib / Arenex Digital. This plugin is **live on real client sites**.
> Suhaib is learning and is **not a code developer** — explain steps simply, no jargon.

---

## 🚫 RULE #1 — NEVER bump the version on a normal change
When you fix, edit, tweak, or improve **anything** (widgets, CSS, JS, PHP):
- **DO NOT** change the `Version:` header in `arenex-digital-widgets.php`.
- **DO NOT** change the `ADW_VERSION` constant.
- Just make the edit and stop. Committing the change is fine — **the version stays exactly the same.**

**A change is NOT a release.** Most of the time the version should stay frozen.

## ✅ RULE #2 — Bump the version ONLY when explicitly told to "release"
Bump the version **only** when Suhaib uses a word like:
**release · ship · publish · make a version · new version · bump version · cut a release.**

When he does:
1. Bump **both** `Version:` and `ADW_VERSION` to the same number.
2. Use semantic versioning:
   - bug fix → last digit (`1.0.0` → `1.0.1`)
   - new feature → middle digit (`1.0.0` → `1.1.0`)
   - big / breaking → first digit (`1.0.0` → `2.0.0`)
3. Then, if asked, create the tag + GitHub Release.

## 🌿 RULE #3 — Pushing to GitHub does NOT update any website
- `git push` / "Push origin" in GitHub Desktop = **a backup only.** No site changes.
- Client sites update **only** when Suhaib uploads a zip, or a GitHub **Release** is published (auto-update sites via Git Updater).
- So during development: **commit + push freely — it is always safe.**

---

## Workflow summary (the loop)
- **While building (test sites):** edit → commit → push. **No version bump.**
- **When a batch is ready & tested:** Suhaib says *"release"* → bump version → tag → publish Release.
- **Deploy:** manual zip upload to clients, or a published Release for Git-Updater sites.

## History note
- `5.1.4` shipped because it was an explicit "push it live" request (the mobile drawer double-arrow fix). That was a **real release**. Routine edits are **not** releases.
