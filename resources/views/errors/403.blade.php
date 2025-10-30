<x-layouts.app title="Access Denied">
    <div class="flex flex-col items-center justify-center min-h-[60vh] bg-gray-900 text-white p-6 rounded-xl shadow-lg">
        <h1 class="mb-4 text-6xl font-bold text-red-400">403</h1>
        <h2 class="mb-2 text-3xl font-semibold">Access Denied</h2>
        <p class="max-w-md mb-6 text-center text-gray-200">
            You do not have permission to perform this action.
        </p>
        <a href="{{ url()->previous() }}" class="px-6 py-3 font-semibold transition bg-red-600 rounded-lg hover:bg-red-700">
            Go Back
        </a>
    </div>
</x-layouts.app>
