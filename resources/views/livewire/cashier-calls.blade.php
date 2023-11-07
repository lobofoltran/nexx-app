<div wire:poll.5000ms>
    <div class="grid grid-cols-3 gap-4 mt-2 text-white">
        @if ($calls)
        @foreach ($calls as $call)
            <div tabindex="0" wire:keydown.enter="setDone({{ $call }})" wire:click="setDone({{ $call }})"" class="focus:ring-4 ring-offset-2 ring-offset-slate-50 flex flex-col relative justify-between p-4 rounded-lg text-white border-sky-600 bg-sky-500 shadow-lg w-full cursor-pointer">
                <div class="text-center flex-none"><i class="fas fa-chair"></i> {{ $call->table->id }} ({{ $call->table->identity }})</div>
                <hr class="my-2">
                <div class="text-center flex-none">{{ $call->type }}</div>
            </div>
        @endforeach
        @else
            Nenhuma chamada disponível!
        @endif
    </div>
</div>