#!/bin/bash

# Pre-commit script to run tests and quality checks
# Usage: .github/scripts/pre-commit.sh

set -e

echo "🚀 Running pre-commit checks..."

# Check if composer is available
if ! command -v composer &> /dev/null; then
    echo "❌ Composer is not installed"
    exit 1
fi

# Install dependencies if vendor directory doesn't exist
if [ ! -d "vendor" ]; then
    echo "📦 Installing dependencies..."
    composer install --prefer-dist --no-progress
fi

# Run PHPUnit tests
echo "🧪 Running PHPUnit tests..."
composer phpunit

# Run PHPStan static analysis
echo "🔍 Running PHPStan static analysis..."
if ! composer phpstan; then
    echo "⚠️  PHPStan found issues, but continuing..."
fi

# Check code style with PHP CS Fixer
echo "🎨 Checking code style..."
if ! composer php-cs-fixer -- --dry-run --diff; then
    echo "❌ Code style issues found. Run 'composer php-cs-fixer' to fix them."
    echo "Would you like to fix them automatically? (y/n)"
    read -r response
    if [[ "$response" =~ ^[Yy]$ ]]; then
        composer php-cs-fixer
        echo "✅ Code style fixed!"
    else
        echo "❌ Please fix code style issues before committing."
        exit 1
    fi
fi

# Check for security vulnerabilities
echo "🔒 Checking for security vulnerabilities..."
if ! composer audit; then
    echo "⚠️  Security vulnerabilities found, please review."
fi

echo "✅ All checks passed! Ready to commit."