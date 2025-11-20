@props([
    'type' => '',
    'message' => '',
    'id' => '',
    'index' => 0,
])

@php
  $hover = 'hover:cursor-pointer';

  if ($type == "error") {
    $hover = $hover . ' dark:hover:bg-rose-800';
  }
  else {
    $hover = $hover . ' dark:hover:bg-emerald-800';
  }

  $classes = [
    "error" => "text-sm text-red-800 rounded-xl bg-red-50 dark:bg-rose-900 dark:text-rose-300",
    "success" => "text-sm text-emerald-800 rounded-xl bg-emerald-50 dark:bg-emerald-900 dark:text-emerald-300"
  ];

  $className = $classes[$type];

  $z = 50 - $index;
  $y = 40 * $index;
@endphp

<div id="alert-{{ $id }}" class="fixed bottom-4 right-8 -translate-y-[{{ $y }}px] z-{{ $z }} flex items-center p-3 gap-2 {{ $className }}" role="alert">
  <svg class="shrink-0 inline w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
  </svg>
  <span class="sr-only">Info</span>
  <span class="font-medium">{{ ucfirst($type) }} alert:&nbsp;</span>{{ $message }}
  <button type="button" class="ms-auto -mx-1.5 -my-1.5 rounded-xl p-1.5 {{ $hover }} inline-flex items-center justify-center h-8 w-8 shrink-0" data-dismiss-target="#alert-{{ $id }}" aria-label="Close">
    <span class="sr-only">Close</span>
      <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/></svg>
  </button>
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



