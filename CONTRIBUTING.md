# Contributing to MapMaster

Thank you for considering contributing to the MapMaster project! This document outlines the guidelines and processes for contributing to the codebase.

## Code of Conduct

By participating in this project, you agree to abide by the [Code of Conduct](CODE_OF_CONDUCT.md). Please read it before contributing.

## Getting Started

1. Fork the repository
2. Clone the forked repository to your local machine
3. Install dependencies as described in the [Installation Guide](INSTALLATION.md)
4. Create a new branch for your feature or bug fix
5. Make your changes and commit them
6. Push to your fork and submit a pull request

## Development Environment

Please ensure your development environment meets the requirements specified in the [Installation Guide](INSTALLATION.md).

### Recommended Tools

- **IDE**: Visual Studio Code or PhpStorm with Laravel plugins
- **API Testing**: Postman or Insomnia
- **Database Management**: TablePlus, MySQL Workbench, or phpMyAdmin
- **Git Client**: SourceTree, GitKraken, or GitHub Desktop (if you prefer GUI over command line)

## Coding Standards

We follow the [PSR-12 coding standard](https://www.php-fig.org/psr/psr-12/) and the [Laravel coding style](https://laravel.com/docs/10.x/contributions#coding-style). Please ensure your code follows these standards.

### PHP Code Style

We use Laravel Pint for code style enforcement. Run the following command before submitting your pull request:

```bash
./vendor/bin/pint
```

### JavaScript/CSS Code Style

For frontend code, we use ESLint and Prettier. Run the following commands:

```bash
npm run lint
npm run format
```

## Testing

All new features and bug fixes should include appropriate tests. We use PHPUnit for backend testing.

To run tests:

```bash
php artisan test
```

For JavaScript components, we use Jest:

```bash
npm run test
```

## Pull Request Process

1. Update the README.md and documentation with details of changes to the interface, if applicable
2. Run all tests and ensure they pass
3. Update the CHANGELOG.md with details of your changes
4. The PR should target the `develop` branch, not `main`
5. Your PR needs to be approved by at least one maintainer before it can be merged

## Branch Naming Convention

- `feature/short-description` - For new features
- `bugfix/issue-description` - For bug fixes
- `hotfix/issue-description` - For critical fixes
- `docs/what-changed` - For documentation only changes
- `refactor/component-name` - For code refactoring

## Commit Messages

We follow the [Conventional Commits](https://www.conventionalcommits.org/) specification. This leads to more readable messages that are easy to follow when looking through the project history.

Examples:

- `feat: add user authentication API`
- `fix: resolve issue with design image display`
- `docs: update API documentation`
- `refactor: restructure design controller`
- `test: add tests for payment processing`

## Database Changes

If your contribution includes database changes:

1. Create a new migration with `php artisan make:migration`
2. Make sure migrations are reversible (include proper down() methods)
3. If needed, update seeders or factories
4. Document the changes in your PR description

## Adding New Dependencies

Before adding a new dependency:

1. Discuss with the team if there's a necessity for a new package
2. Consider the package's maintenance status, size, and security
3. Document why the package is being added in the PR description

## Documentation

Please update the documentation when necessary:

- README.md - For high-level overview and setup
- API.md - For API changes
- Inline documentation - Use proper PHPDoc blocks for classes and methods

## Where to Start?

Check the [Issues](https://github.com/yourusername/mapmaster/issues) tab for:

- Issues labeled with `good first issue` for beginners
- `help wanted` for issues needing assistance
- `bug` for fixing problems in the codebase
- `feature` for adding new functionality

## Questions?

If you have any questions or need further guidance, feel free to:

1. Open an issue with the label `question`
2. Contact the maintainers directly
3. Ask in the community discussion channels

Thank you for contributing to MapMaster!
