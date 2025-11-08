<x-guest-layout>
	<form class="form w-100" novalidate="novalidate" id="kt_role_select_form" method="POST" action="{{ route('role.store') }}">
		@csrf

		<div class="text-center mb-11">
			<h1 class="text-dark fw-bolder mb-3">{{ __('common.select_role', ['app' => config('app.name')]) }}</h1>
			<div class="text-gray-500 fw-semibold fs-6">{{ __('common.select_role_description', [], app()->getLocale()) }}</div>
		</div>

		@if (session('status'))
			<div class="alert alert-success mb-5">{{ session('status') }}</div>
		@endif

		{{-- Roles list --}}
		<div class="row gx-6 gy-6 mb-8">
			@forelse($roles as $role)
				<div class="col-12 col-md-6">
					<label class="card h-100 cursor-pointer role-card border" for="role_{{ $role->id }}">
						<input type="radio" name="role_id" id="role_{{ $role->id }}" value="{{ $role->id }}" class="d-none" {{ $loop->first ? 'checked' : '' }} />
						<div class="card-body d-flex flex-column">
							<div class="d-flex align-items-center justify-content-between mb-3">
								<div class="d-flex align-items-center">
									<span class="fw-bold text-dark fs-5">{{ $role->display_name ?? $role->name }}</span>
								</div>
								<div>
									<i class="fas fa-user-tag text-muted"></i>
								</div>
							</div>

							@if(!empty($role->description))
								<div class="text-muted small mb-3">{{ $role->description }}</div>
							@endif
						</div>
					</label>
				</div>
			@empty
				<div class="col-12">
					<div class="alert alert-warning">{{ __('common.no_roles_available') }}</div>
				</div>
			@endforelse
		</div>

		@error('role_id')
			<div class="invalid-feedback d-block mb-4">{{ $message }}</div>
		@enderror

		<div class="d-flex justify-content-end">
			<div class="d-grid" style="width:160px">
				<button type="submit" id="kt_role_select_submit" class="btn btn-primary">
					<span class="indicator-label">{{ __('common.continue') }}</span>
					<span class="indicator-progress">{{ __('common.loading') }}
						<span class="spinner-border spinner-border-sm align-middle ms-2"></span>
					</span>
				</button>
			</div>
		</div>
	</form>

	<script>
		// Visual selection using existing utility classes only (no custom CSS)
		(function () {
			function clearSelection() {
				document.querySelectorAll('.role-card').forEach(function (c) {
					c.classList.remove('border-primary', 'shadow', 'bg-light');
				});
			}

			function markSelectedByInput(input) {
				clearSelection();
				if (!input) return;
				const card = input.closest('.role-card');
				if (card) {
					// Use Bootstrap utility classes to indicate selection
					card.classList.add('border-primary', 'shadow', 'bg-light');
				}
			}

			// Click on card should check the radio and mark selection
			document.addEventListener('click', function (e) {
				const card = e.target.closest('.role-card');
				if (!card) return;
				const input = card.querySelector('input[type=radio]');
				if (input) {
					input.checked = true;
					input.dispatchEvent(new Event('change', { bubbles: true }));
				}
				markSelectedByInput(card.querySelector('input[type=radio]'));
			});

			// Listen for radio changes (keyboard/navigation support)
			document.querySelectorAll('input[name="role_id"]').forEach(function (input) {
				input.addEventListener('change', function () {
					if (this.checked) markSelectedByInput(this);
				});
			});

			// On page load, ensure the checked radio has the selection classes
			document.addEventListener('DOMContentLoaded', function () {
				const checked = document.querySelector('input[name="role_id"]:checked');
				if (checked) markSelectedByInput(checked);
			});
		})();
	</script>
</x-guest-layout>
