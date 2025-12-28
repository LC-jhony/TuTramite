# TuTramite - Document Management System

## Project Overview

TuTramite is a Laravel-based document management system designed for handling document procedures and workflows. The application allows users to register, track, and manage documents with file attachments, primarily focusing on external document submissions (tramites).

### Key Features
- External document submission form for public users
- Document management with file attachments
- Customer management for document owners
- Document types, offices, and administration tracking
- File management with PDF preview capabilities
- Admin panel built with Filament PHP

### Technology Stack
- **Framework**: Laravel 12.x
- **PHP Version**: 8.2+
- **Admin Panel**: Filament 4.3+
- **Frontend**: Livewire components with advanced file upload
- **Database**: Eloquent ORM with migrations

## Architecture

### Core Models
- `Document`: Main entity representing a document/tramite
- `DocumentFile`: File attachments associated with documents
- `Customer`: Represents document owners (individuals or companies)
- `DocumentType`: Categorization of different document types
- `Office`: Represents different administrative offices
- `Administration`: Represents different administrative periods/gestions
- `User`: Authentication users for the admin panel

### Key Components
- `DocumentProcedureForm`: Public-facing Livewire component for document submission
- `DocumentService`: Service class handling document creation and file management
- `Filament Resources`: Admin panel interfaces for managing all entities

## File Structure

```
app/
├── Filament/           # Admin panel resources
├── Http/               # HTTP controllers and middleware
├── Livewire/           # Livewire components (DocumentProcedureForm.php)
├── Models/             # Eloquent models
├── Providers/          # Service providers including Filament
└── Services/           # Business logic services (DocumentService.php)
```

## Building and Running

### Prerequisites
- PHP 8.2+
- Composer
- Node.js and npm
- Database (MySQL, PostgreSQL, or SQLite)

### Setup Commands
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run database migrations
php artisan migrate

# Build frontend assets
npm run build
```

### Development Commands
```bash
# Run development server
composer run dev

# Run tests
composer run test

# Serve the application
php artisan serve
```

### Quick Setup Script
```bash
composer run setup
```

## Development Conventions

### Coding Standards
- Follow PSR-12 coding standards
- Use Laravel naming conventions
- Type hinting for all method parameters and return types
- Follow Filament PHP conventions for admin panels

### Database Migrations
- Use Laravel's migration system for schema changes
- Maintain proper relationships between models
- Include seeders for development data

### Testing
- Use PestPHP for testing (as configured in composer.json)
- Write feature and unit tests for new functionality
- Run tests with `composer run test`

### File Uploads
- PDF files are stored in the `storage/app/documents/` directory
- File metadata is stored in the `document_files` table
- Advanced PDF preview capabilities using the asmit/filament-upload package

## Key Functionalities

### Document Registration
- Public form for external document submission
- Automatic document number generation
- File attachment with PDF preview
- Customer creation/association
- Validation and processing

### Admin Panel
- Full CRUD operations for all entities
- Document management with file viewing
- Customer management
- Document type and office configuration
- Administrative controls

### Document Lifecycle
- Registration → In Process → Completed → Archived
- File attachment and management
- Customer tracking
- Status updates and notifications

## Important Notes

1. The application distinguishes between internal and external documents
2. External documents are submitted through a public form without authentication
3. The DocumentService handles the complex logic of document creation and file management
4. The system includes comprehensive admin functionality via Filament
5. File uploads are handled with security and validation measures

## Security Considerations

- File upload validation and security measures
- Authentication for admin panel access
- Input validation for all user inputs
- Proper authorization checks in admin panel

## Troubleshooting

If you encounter issues with the document submission form:
1. Check that the DocumentService can properly handle null user IDs for external documents
2. Ensure file upload directories have proper write permissions
3. Verify database migrations have been run successfully