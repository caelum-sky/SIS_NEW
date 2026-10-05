<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-500 rounded-md font-semibold text-sm text-white shadow-md transition ease-in-out duration-150 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2']) }}>
    {{ $slot }}
</button>
