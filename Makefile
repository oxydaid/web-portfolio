# ═══════════════════════════════════════════════════════
# Portfolio CI/CD - Local Test Runner
# ═══════════════════════════════════════════════════════
# Usage:
#   make test          → Run all tests
#   make quality       → Code quality checks only
#   make security      → Security audit only
#   make ci            → Full CI pipeline (same as GitHub)
# ═══════════════════════════════════════════════════════

.PHONY: help quality lint analyse test test-unit test-feature test-security security audit ci coverage clean

# Default target
help: ## Show this help message
	@echo ""
	@echo "  ╔══════════════════════════════════════════════╗"
	@echo "  ║     Portfolio CI/CD - Local Test Runner      ║"
	@echo "  ╚══════════════════════════════════════════════╝"
	@echo ""
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[36m%-20s\033[0m %s\n", $$1, $$2}'
	@echo ""

# ─── Code Quality ────────────────────────────────────

quality: lint analyse ## Run all code quality checks

lint: ## Check code style with Laravel Pint
	@echo "\n🎨 Checking code style..."
	@vendor/bin/pint --test
	@echo "✅ Code style OK"

lint-fix: ## Fix code style automatically
	@echo "\n🎨 Fixing code style..."
	@vendor/bin/pint
	@echo "✅ Code style fixed"

analyse: ## Run static analysis with PHPStan
	@echo "\n📐 Running static analysis..."
	@vendor/bin/phpstan analyse --memory-limit=512M --no-progress
	@echo "✅ Static analysis OK"

# ─── Tests ───────────────────────────────────────────

test: ## Run all tests (unit + feature)
	@echo "\n🧪 Running all tests..."
	@php artisan config:clear --ansi 2>/dev/null || true
	@vendor/bin/pest --colors=always

test-unit: ## Run unit tests only
	@echo "\n🧪 Running unit tests..."
	@vendor/bin/pest --testsuite=Unit --colors=always

test-feature: ## Run feature tests only
	@echo "\n🧩 Running feature tests..."
	@php artisan config:clear --ansi 2>/dev/null || true
	@vendor/bin/pest --testsuite=Feature --colors=always

test-security: ## Run security-focused tests only
	@echo "\n🔒 Running security tests..."
	@php artisan config:clear --ansi 2>/dev/null || true
	@vendor/bin/pest --filter=Security --colors=always

coverage: ## Run tests with coverage report
	@echo "\n📊 Running tests with coverage..."
	@php artisan config:clear --ansi 2>/dev/null || true
	@vendor/bin/pest --coverage --colors=always

coverage-min: ## Run tests with minimum coverage threshold (50%)
	@echo "\n📊 Running tests with coverage threshold..."
	@php artisan config:clear --ansi 2>/dev/null || true
	@vendor/bin/pest --coverage --min=50 --colors=always

# ─── Security ────────────────────────────────────────

security: audit npm-audit secret-scan ## Run all security checks

audit: ## Audit PHP dependencies for vulnerabilities
	@echo "\n🔒 Auditing PHP dependencies..."
	@composer audit --format=plain
	@echo "✅ PHP dependencies OK"

npm-audit: ## Audit NPM dependencies for vulnerabilities
	@echo "\n🔒 Auditing NPM dependencies..."
	@npm audit --audit-level=high || true
	@echo "ℹ️  NPM audit complete"

secret-scan: ## Scan for hardcoded secrets
	@echo "\n🔍 Scanning for hardcoded secrets..."
	@FOUND=$$(grep -rn --include="*.php" -E "(password\s*=\s*['\"][a-zA-Z0-9].{7,}['\"])" app/ config/ --exclude-dir=vendor 2>/dev/null | grep -v "env(" | grep -v "config(" | grep -v "//" | grep -v "password_verify" | grep -v "password_hash" | grep -v "fillable" | grep -v "hidden" | grep -v "'password'" | grep -v "password_confirmation" | grep -v "min:" || true); \
	if [ -n "$$FOUND" ]; then \
		echo "$$FOUND"; \
		echo "⚠️  Potential hardcoded secrets found (review above)"; \
	else \
		echo "✅ No obvious hardcoded secrets detected"; \
	fi
	@echo "\n🔍 Checking .env.example..."
	@SECRETS=$$(grep -E "^(APP_KEY=base64:|DB_PASSWORD=[a-zA-Z0-9].{7,}|MAIL_PASSWORD=[a-zA-Z0-9].{7,})" .env.example 2>/dev/null || true); \
	if [ -n "$$SECRETS" ]; then \
		echo "$$SECRETS"; \
		echo "⚠️  .env.example may contain real secrets!"; \
		exit 1; \
	else \
		echo "✅ .env.example looks clean"; \
	fi

# ─── Full CI Pipeline ───────────────────────────────

ci: quality test security ## Run full CI pipeline (mirrors GitHub Actions)
	@echo ""
	@echo "  ╔══════════════════════════════════════════════╗"
	@echo "  ║          ✅ Full CI Pipeline PASSED          ║"
	@echo "  ╚══════════════════════════════════════════════╝"
	@echo ""

# ─── Utilities ───────────────────────────────────────

clean: ## Clear all caches
	@echo "\n🧹 Clearing caches..."
	@php artisan config:clear 2>/dev/null || true
	@php artisan cache:clear 2>/dev/null || true
	@php artisan route:clear 2>/dev/null || true
	@php artisan view:clear 2>/dev/null || true
	@echo "✅ Caches cleared"
