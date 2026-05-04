# TESTING.md

## 1. Testing Overview

Phase 6 focuses on **functional correctness** and **security validation** for the Fresh Flower Selling Website (Laravel 11).

### Goals

- Validate core user and admin business flows end-to-end.
- Confirm critical security controls are working in real scenarios.
- Detect regression risks before production release.
- Provide a repeatable manual verification checklist for QA and developers.

### Scope

- Functional tests for User flows (Register, Login, Cart, Checkout).
- Functional tests for Admin flows (Category/Product CRUD, Order management).
- Security tests for access control, XSS, CSRF, SQL injection resilience, and upload validation.

## 2. Functional Test Cases

### QA Execution Matrix Legend

- Priority: P0 (critical), P1 (high), P2 (medium), P3 (low).
- Severity: S1 (critical impact), S2 (major), S3 (minor), S4 (cosmetic).
- Owner: QA assignee responsible for execution in current sprint.
- Evidence link: URL/path to screenshot, video, log, or test report.
- Defect ID: Ticket ID in tracker (JIRA/Azure DevOps), or N/A if passed.

### 2.1 User Flows

| Verify | Test ID | Feature | Priority | Severity | Owner | Preconditions | Steps | Expected Result | Evidence link | Defect ID |
|---|---|---|---|---|---|---|---|---|---|---|
| [ ] | FUNC-USER-001 | Register | P0 | S1 | QA Team | User is not logged in | Open Register page -> Enter valid name/email/password -> Submit | Account is created, user is authenticated, and redirected to expected page |  | N/A |
| [ ] | FUNC-USER-002 | Login | P0 | S1 | QA Team | Existing active user account | Open Login page -> Enter valid credentials -> Submit | User logs in successfully and session is established |  | N/A |
| [ ] | FUNC-USER-003 | Login validation | P1 | S2 | QA Team | Existing user account | Open Login page -> Enter invalid password -> Submit | Login is rejected with proper validation/error message |  | N/A |
| [ ] | FUNC-USER-004 | Cart flow | P0 | S1 | QA Team | At least one active product exists | Browse products -> Add product to cart -> Update quantity -> Remove item | Cart totals update correctly, removed item no longer appears |  | N/A |
| [ ] | FUNC-USER-005 | Checkout | P0 | S1 | QA Team | Logged-in user with non-empty cart | Open cart -> Proceed to checkout -> Fill shipping/contact fields -> Place order | Order is created with correct total and items, cart is cleared |  | N/A |
| [ ] | FUNC-USER-006 | Order history visibility | P1 | S2 | QA Team | Logged-in user with at least one order | Open My Orders page | User sees only their own orders with correct status and totals |  | N/A |

### 2.2 Admin Flows

| Verify | Test ID | Feature | Priority | Severity | Owner | Preconditions | Steps | Expected Result | Evidence link | Defect ID |
|---|---|---|---|---|---|---|---|---|---|---|
| [ ] | FUNC-ADMIN-001 | Category Create | P1 | S2 | QA Team | Logged in as admin | Open Admin Category Management -> Create category with valid name | New category is persisted and listed |  | N/A |
| [ ] | FUNC-ADMIN-002 | Category Update | P1 | S2 | QA Team | Existing category | Edit category name -> Save | Category is updated and reflected in list |  | N/A |
| [ ] | FUNC-ADMIN-003 | Category Delete | P1 | S2 | QA Team | Existing category not blocked by constraints | Delete category -> Confirm action | Category is removed (or safe validation message shown if constrained) |  | N/A |
| [ ] | FUNC-ADMIN-004 | Product Create | P0 | S1 | QA Team | Existing category | Open Product Management -> Create product with valid inputs and image | Product is stored and appears in product list |  | N/A |
| [ ] | FUNC-ADMIN-005 | Product Update | P0 | S1 | QA Team | Existing product | Edit product fields (name, price, status) -> Save | Product updates are saved correctly |  | N/A |
| [ ] | FUNC-ADMIN-006 | Product Delete | P1 | S2 | QA Team | Existing product | Delete product | Product is removed from active listing |  | N/A |
| [ ] | FUNC-ADMIN-007 | Order status update | P0 | S1 | QA Team | Existing order in pending state | Open Admin Orders -> Change status (pending/completed/cancelled) -> Submit | Status is updated and shown correctly in list/detail |  | N/A |
| [ ] | FUNC-ADMIN-008 | Order filtering | P1 | S2 | QA Team | Multiple orders with mixed status/date | In Admin Orders, apply status/date filters -> Submit | Results match selected filters exactly |  | N/A |
| [ ] | FUNC-ADMIN-009 | Order pagination | P1 | S2 | QA Team | Enough records for multiple pages | Open Admin Orders -> Navigate pages | Pagination works, filters/search parameters persist across pages |  | N/A |
| [ ] | FUNC-ADMIN-010 | Order search | P1 | S2 | QA Team | Orders with known customer names and IDs | Search by order ID and customer name | Matching orders are returned; irrelevant records are excluded |  | N/A |

## 3. Security Test Cases (Critical)

| Verify | Test ID | Security Area | Priority | Severity | Owner | Preconditions | Steps | Expected Result | Evidence link | Defect ID |
|---|---|---|---|---|---|---|---|---|---|---|
| [ ] | SEC-001 | Broken Access Control | P0 | S1 | Security QA | Non-admin user account exists | Login as non-admin -> Attempt direct access to `/admin`, `/admin/categories`, `/admin/orders`, `/admin/products` | Access is denied (403 or redirect). No admin data/action allowed |  | N/A |
| [ ] | SEC-002 | XSS Prevention | P0 | S1 | Security QA | Any text input field available (e.g., category/product name, profile/order note if present) | Enter payload like `<script>alert('xss')</script>` -> Submit and render page | Script is escaped/sanitized and never executes in browser |  | N/A |
| [ ] | SEC-003 | CSRF Protection | P0 | S1 | Security QA | Any state-changing form endpoint available | Submit POST/PATCH/DELETE request without CSRF token (manual request/curl/Postman) | Request is rejected with CSRF/token mismatch response |  | N/A |
| [ ] | SEC-004 | SQL Injection | P0 | S1 | Security QA | Search/filter fields available (`q`, login fields, etc.) | Try payloads like `' OR 1=1 --` and `" OR "1"="1` in inputs | No SQL error leakage, no auth bypass/data overexposure, safe handled response |  | N/A |
| [ ] | SEC-005 | File Upload Validation | P0 | S1 | Security QA | Admin product image upload available | Attempt upload of non-image files (`.php`, `.exe`, `.js`, renamed text file) | Upload is blocked by validation, no executable file stored as image |  | N/A |

### Security Notes

- Verify custom admin middleware is consistently applied to all `/admin/*` routes.
- Confirm Laravel Blade output escaping (`{{ }}`) is used for user-controlled content.
- Confirm upload validation includes MIME/type and extension checks.

## 4. Environment

| Item | Value |
|---|---|
| Framework | Laravel 11 |
| PHP Version | PHP 8.3 |
| Database | MySQL |

### Recommended Test Setup

- Use a dedicated QA database with seeded sample data.
- Ensure at least two roles exist: one admin and one non-admin user.
- Enable application logging for failed authorization and validation attempts.

## Execution Sign-off

- [ ] All functional test cases executed.
- [ ] All critical security test cases executed.
- [ ] All failed cases documented with reproduction steps and evidence.
- [ ] Retest completed for all fixes.

## Sprint Tracking Fields

- [ ] Priority and Severity confirmed by QA Lead before sprint test execution.
- [ ] Owner assigned for each test case.
- [ ] Evidence link attached for each executed test case.
- [ ] Defect ID linked for each failed test case.