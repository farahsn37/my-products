//models

- User
    - email (string)
    - name (string)
    - password (hashed string)
    - created_at, updated_at (timestamps)

- Document
    - title (string)
    - content (text)
    - user_id (foreign key to users)
    - created_at, updated_at (timestamps) -->
- Role
    - Available Roles:
        - Admin
        - Manager
        - Employee
- Permission
  -Available Permissions: - create document - view document - edit document - delete document

1. Create document model and migration.
2. populate roles and permission in the system.
3. Create Users, create ProductFactory, create documents for each users, assign permissions to the roles, assign roles and permission.
4. Create document controller and necessary routes.
