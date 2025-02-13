<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-orange border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange/90 focus:bg-orange/90 active:bg-orange/90 focus:outline-none focus:ring-2 focus:ring-orange focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
