@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-slate-700 bg-slate-800/70 text-slate-100 placeholder:text-slate-500 focus:border-blue-500 focus:ring-blue-500/40 rounded-md shadow-sm']) }}>
