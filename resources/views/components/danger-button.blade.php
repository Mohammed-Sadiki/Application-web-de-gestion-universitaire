<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#d946ef]/10 border border-[#d946ef]/30 rounded-xl font-bold text-xs text-[#d946ef] uppercase tracking-widest hover:bg-[#d946ef]/20 active:bg-[#d946ef]/30 focus:outline-none transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
