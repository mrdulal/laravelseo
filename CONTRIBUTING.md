# Contributing to Laravel SEO Pro

Thank you for considering contributing to Laravel SEO Pro! We welcome contributions from the community and appreciate your help in making this package better.

## Table of Contents

- [Code of Conduct](#code-of-conduct)
- [Getting Started](#getting-started)
- [How to Contribute](#how-to-contribute)
- [Development Setup](#development-setup)
- [Testing](#testing)
- [Documentation](#documentation)
- [Pull Request Process](#pull-request-process)
- [Issue Reporting](#issue-reporting)

## Code of Conduct

This project and everyone participating in it is governed by our [Code of Conduct](CODE_OF_CONDUCT.md). By participating, you are expected to uphold this code.

## Getting Started

1. **Fork the repository** on GitHub
2. **Clone your fork** locally
3. **Create a new branch** for your feature or bugfix
4. **Make your changes** following our coding standards
5. **Test your changes** thoroughly
6. **Submit a pull request** with a clear description

## How to Contribute

### Types of Contributions

We welcome several types of contributions:

- **Bug fixes** - Fix issues and improve stability
- **New features** - Add new functionality
- **Documentation** - Improve or add documentation
- **Tests** - Add or improve test coverage
- **Performance** - Optimize existing code
- **Examples** - Add usage examples

### Before You Start

1. **Check existing issues** to see if your idea is already being discussed
2. **Open an issue** for significant changes to discuss the approach
3. **Read the documentation** to understand the codebase
4. **Follow the coding standards** outlined below

## Development Setup

### Prerequisites

- PHP 8.1 or higher
- Composer
- Laravel 9.0 or higher
- Node.js and NPM (for frontend assets)

### Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/laravel-seo-pro/seo-pro.git
   cd seo-pro
   ```

2. **Install dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Set up the test environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Run migrations:**
   ```bash
   php artisan migrate
   ```

5. **Run tests to ensure everything works:**
   ```bash
   composer test
   ```

### Development Commands

```bash
# Run tests
composer test

# Run tests with coverage
composer test-coverage

# Run PHP CS Fixer
composer fix

# Run PHPStan
composer analyse

# Build assets
npm run build

# Watch for changes
npm run watch
```

## Testing

### Writing Tests

- **Write tests for new features** - Every new feature should have corresponding tests
- **Write tests for bug fixes** - Ensure the bug doesn't regress
- **Test edge cases** - Consider unusual inputs and scenarios
- **Use descriptive test names** - Make it clear what each test does

### Test Structure

```php
<?php

namespace LaravelSeoPro\Tests\Unit;

use LaravelSeoPro\Services\SeoService;
use Orchestra\Testbench\TestCase;

class SeoServiceTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \LaravelSeoPro\Providers\SeoProServiceProvider::class,
        ];
    }

    public function test_can_set_title()
    {
        $seo = new SeoService();
        $seo->setTitle('Test Title');
        
        $this->assertEquals('Test Title', $seo->getTitle());
    }
}
```

### Running Tests

```bash
# Run all tests
composer test

# Run specific test file
./vendor/bin/phpunit tests/Unit/SeoServiceTest.php

# Run tests with coverage
composer test-coverage
```

## Documentation

### Documentation Standards

- **Use clear, concise language** - Write for developers of all skill levels
- **Include code examples** - Show how to use features
- **Keep documentation up to date** - Update docs when code changes
- **Use proper markdown formatting** - Follow markdown best practices

### Documentation Structure

```
docs/
├── getting-started/
│   ├── installation.md
│   └── quick-start.md
├── components/
│   ├── blade-components.md
│   ├── livewire-components.md
│   └── filament-integration.md
├── features/
│   ├── meta-tags.md
│   ├── open-graph.md
│   └── json-ld.md
├── examples/
│   ├── basic-usage.md
│   └── advanced-usage.md
└── api/
    ├── seo-facade.md
    └── has-seo-trait.md
```

### Writing Documentation

1. **Start with an overview** - Explain what the feature does
2. **Provide examples** - Show how to use it
3. **Include configuration options** - Document all available options
4. **Add troubleshooting** - Help users solve common issues
5. **Link to related topics** - Connect related documentation

## Pull Request Process

### Before Submitting

1. **Ensure tests pass** - All tests must pass
2. **Follow coding standards** - Use PHP CS Fixer
3. **Update documentation** - Document new features
4. **Add changelog entry** - Update CHANGELOG.md
5. **Test manually** - Verify your changes work as expected

### Pull Request Template

Use the provided pull request template:

```markdown
## Description
Brief description of what this PR does.

## Type of Change
- [ ] Bug fix (non-breaking change which fixes an issue)
- [ ] New feature (non-breaking change which adds functionality)
- [ ] Breaking change (fix or feature that would cause existing functionality to not work as expected)
- [ ] Documentation update
- [ ] Performance improvement
- [ ] Code refactoring

## Testing
- [ ] Tests pass locally
- [ ] New tests added for new functionality
- [ ] Manual testing completed

## Checklist
- [ ] My code follows the project's style guidelines
- [ ] I have performed a self-review of my own code
- [ ] I have commented my code, particularly in hard-to-understand areas
- [ ] I have made corresponding changes to the documentation
- [ ] My changes generate no new warnings
- [ ] I have added tests that prove my fix is effective or that my feature works
- [ ] New and existing unit tests pass locally with my changes
```

### Review Process

1. **Automated checks** - CI/CD pipeline runs tests and checks
2. **Code review** - Maintainers review the code
3. **Feedback** - Address any feedback from reviewers
4. **Approval** - Once approved, the PR will be merged

## Issue Reporting

### Before Creating an Issue

1. **Search existing issues** - Check if the issue already exists
2. **Check documentation** - Make sure it's not a documentation issue
3. **Try the latest version** - Ensure you're using the latest version

### Issue Templates

Use the provided issue templates:

- **Bug Report** - For reporting bugs
- **Feature Request** - For requesting new features
- **Documentation** - For documentation issues

### Good Issue Reports

Include the following information:

- **Clear title** - Summarize the issue in one line
- **Description** - Detailed description of the issue
- **Steps to reproduce** - How to reproduce the issue
- **Expected behavior** - What should happen
- **Actual behavior** - What actually happens
- **Environment** - PHP version, Laravel version, package version
- **Screenshots** - If applicable
- **Code examples** - Minimal code to reproduce the issue

## Coding Standards

### PHP

- Follow [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standards
- Use PHP 8.1+ features where appropriate
- Write self-documenting code with clear variable names
- Add type hints for all parameters and return types
- Use strict typing (`declare(strict_types=1);`)

### JavaScript/CSS

- Follow modern JavaScript standards
- Use meaningful variable and function names
- Add comments for complex logic
- Use consistent indentation (2 spaces)

### Documentation

- Use clear, concise language
- Include code examples
- Follow markdown best practices
- Keep documentation up to date

## Release Process

### Versioning

We follow [Semantic Versioning](https://semver.org/):

- **MAJOR** - Breaking changes
- **MINOR** - New features (backward compatible)
- **PATCH** - Bug fixes (backward compatible)

### Release Checklist

1. **Update version** in composer.json
2. **Update CHANGELOG.md** with new features and fixes
3. **Run all tests** to ensure everything works
4. **Update documentation** if needed
5. **Create release** on GitHub
6. **Publish to Packagist** (automatic via GitHub Actions)

## Community

### Getting Help

- **GitHub Discussions** - For questions and general discussion
- **Discord** - For real-time chat and support
- **GitHub Issues** - For bug reports and feature requests

### Recognition

Contributors will be recognized in:

- **CONTRIBUTORS.md** - List of all contributors
- **Release notes** - Credit for significant contributions
- **Documentation** - Credit for documentation contributions

## Thank You

Thank you for contributing to Laravel SEO Pro! Your contributions help make this package better for everyone in the Laravel community.

If you have any questions about contributing, please don't hesitate to ask in our [GitHub Discussions](https://github.com/laravel-seo-pro/seo-pro/discussions) or [Discord](https://discord.gg/laravel-seo-pro).
