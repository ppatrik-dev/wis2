@props([
    'type' => '',
    'message' => '',
    'id' => '',
])

@php
  $classes = [
    "error" => "text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400",
    "success" => "text-sm text-emerald-800 rounded-lg bg-emerald-50 dark:bg-gray-800 dark:text-emerald-400"
  ];

  $className = $classes[$type];
@endphp

<div id="alert-{{ $id }}" class="flex items-center p-3 mb-4 gap-2 {{ $className }}" role="alert">
  <svg class="shrink-0 inline w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
  </svg>
  <span class="sr-only">Info</span>
  <span class="font-medium">{{ ucfirst($type) }} alert:&nbsp;</span>{{ $message }}
  <button type="button" data-dismiss-target="#alert-{{ $id }}" class="ms-auto -mx-1.5 -my-1.5 bg-blue-50 text-blue-500 rounded-lg p-1.5 hover:bg-blue-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-blue-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-1" aria-label="Close">
    <span class="sr-only">Close</span>
    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
    </svg>
</button>
</div>

<script>
document.querySelectorAll('[data-dismiss-target]').forEach(btn => {
  btn.addEventListener('click', () => {
    const target = document.querySelector(btn.getAttribute('data-dismiss-target'));
    if (!target) return;
    target.classList.add('opacity-0');
    setTimeout(() => target.classList.add('hidden'), 300);
  });
});
</script>



