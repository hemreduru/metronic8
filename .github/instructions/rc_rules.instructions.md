# CODE REVIEW CHECKLIST 2.1 (RC)

RC1. Ensuring mobile responsiveness is a must

RC2. Localization
- Creating/using localization files effectively
- For non-Turkish-speaking developers, translation support should be requested from Turkish-speaking teammates
- Based on the content, ChatGPT or GT can be used too

RC3. General UI elements and rules must be followed to ensure/keep consistency
- Consistency must be ensured while developing a new page/module

RC4. Custom CSS should not be used on any occasion (unless unavoidable)

RC5. Only related METRONIC classes (or other approved themes) must be used

RC6. Each button and/or CTA element must be covered with authorization control
- Be careful with the gate controls of repeating rows in data tables

RC7. Unless it’s for public access, any link must be under authentication and authorization
- Authorization control is also a must in places referring to the link (CTA, etc)

RC8. Any public form and CRUD-triggering operation must be covered with Recaptcha
- Every Recaptcha operation must be validated in the back-end from Google

RC9. Any element involving a list must be ordered based on the local language

RC10. Any request/form element must be validated
- HTML Validation (input type, other controls, etc.)
- Additional JS validation (if necessary)
- Laravel validation
- File uploads: 2MB limit (unless approved), sanitized file names

RC11. Every form/input group must involve
- Compulsory status of fields
- Appropriate placeholder
- Appropriate validation notes

RC12. Textarea must show remaining characters dynamically and limit (300 by default)

RC13. Every select element must be Select2
- Unless it conflicts with frontend libs (Vue, Angular)

RC14. Exception handling
- POST requests must catch exceptions
- Report to Sentinel with details
- Report to User appropriately

RC15. Filtering buttons should be inactive without necessary fields

RC16. Any filterable page should allow reset

RC17. Unit/department filter must only show authenticated role’s unit and below (unless approved)

RC18. Every DB/execute operation must be logged (Sentinel etc.)
- Logs must follow a consistent structure (Student No, Course ID, Personnel ID, etc.)

RC19. Every DB alteration/operation must be via migration

RC20. On user-created tables, deleted_at and deleted_by is a must
- Soft delete enabled by default
- created_at, updated_at mandatory

RC21. Laravel naming conventions must be followed

RC22. Every table must be a Datatable (server-side unless static/simple)

RC23. Datatable must be ordered by operation date by default

RC24. Datatable should allow export by default

RC25. Datatable search must be effective, including nullable data

RC26. Datatable must be responsive with column priority

RC27. Ordering/sorting custom columns on server-side datatables must be double-checked

RC28. Code must be cleared from unnecessary blocks

RC29. Code must be cleared from JS console errors

RC30. Deprecated models/services shouldn’t be used

RC31. Pages must have a back button redirecting appropriately

RC32. Models/Requests/Services must have property fields declared

RC33. Custom functions must be documented with input/output

RC34. GET requests/URLs with IDs must be protected
- No direct user manipulation of IDs
- No session variables for updating IDs

RC35. Risky DB operations must be under transaction (commit/rollback via try/catch)

RC36. Try/catch handling is important

RC37. Mail operations must be queued and outside of DB transactions

RC38. System should be user-friendly, documented, accessible

RC39. Developers must provide refactoring/improvement when possible

RC40. Standard practices required
- Naming conventions
- Clear comments
- Indentation
- Portability, Reusability, Scalability
- Testing

RC41. Code readability is vital

RC42. Check for code duplication and unused code

RC43. Always check for unnecessary load
- Lazy/eager loading
- Query optimization
- Page/DB performance

RC44. DB migrations should be reviewed with ERD (if multiple tables)

RC45. Required testing/review scenarios must be documented in issue/MR

RC46. Unit, feature, and general tests must be reviewed and tested

RC47. Any GET link with UI must contain OG/meta tags

RC48. DB performance must be ensured in all db-related actions

RC49. Files/images must be compressed and size-optimized

RC50. Some items might be irrelevant on some occasions — inform and proceed

RC51. Checklist is active unless approved otherwise
