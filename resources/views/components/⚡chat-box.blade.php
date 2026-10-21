<?php

use Livewire\Component;
use App\Ai\Agents\ChatAgent;

new class extends Component {
    // state
    public string $input = '';
    public bool $loading = false;
    public array $messages = [];

    // send message
    public function send() {

        $this->validate([
            'input' => 'required|string|max:2000',
        ]);

        $userMessage = $this->input;
        $this->input = '';
        $this->loading = true;

       try {

         $response = (new ChatAgent)->prompt($userMessage);

        $this->messages[] = [
            'role' => 'assistant',
            'content' => $response->text,
        ];

       }catch (Throwable $e) {

        report($e);

        $this->messages[] = [
            'role' => 'assistant',
            'content' => 'Sorry, something went wrong. Please try again later.',
        ];

       }

         $this->loading = false;

        // dd($response->text);
    }
};
?>

<div class="flex flex-1 flex-col min-w-0">

    {{-- Header --}}

    <header class="px-6 py-4 border-b border-zinc-800 bg-zinc-900/50 flex items-center justify-between flex-shrink-0">

        <div>
            <h1 class="text-sm font-semibold text-white">New Conversation</h1>
            <p class="text-xs text-zinc-500 mt-0.5">Ask me anything</p>
        </div>

        {{-- Button clear --}}

        <button
            class="text-xs text-zinc-500 hover:text-zinc-300 px-3 py-1.5 rounded-md hover:bg-zinc-800 transition-color cursor-pointer">Clear</button>

    </header>

    <div class="flex-1 overflow-y-auto px-4 py-6 space-y-6 scroll-smooth">
        <div class="flex flex-col items-center justify-center h-full text-center py-20">
            <div
                class="w-16 h-16 rounded-2xl bg-gradient-to-br from-violet-500 to-indigo-600 flex items-center justify-center text-2xl font-bold text-white shadow-2xl shadow-violet-900/40 mb-5">
                LC
            </div>

            <h2 class="text-xl font-semibold text-white mb-2">Welcome to LaraChat</h2>
            <p class="text-zinc-400 text-sm max-w-sm leading-relaxed mb-7">AI Assistant</p>

            {{-- Suggest chips --}}

            <div class="flex flex-wrap gap-2 justify-center max-w-sm">
                @foreach (['What is laravel 13?', 'Explain Livewire 4', 'Write a PHP function', 'Tell me a fun fact'] as $suggestion)
                    <button
                        class="cursor-pointer px-3 py-1.5 rounded-full bg-zinc-800 border border-zinc-700 text-xs text-zinc-300 hover:border-violet-500 hover:text-white transition-all duration-200">{{ $suggestion }}</button>
                @endforeach
            </div>
        </div>
    </div>


    {{-- input text --}}

    <div class="flex-shrink-0 px-4 pb-5 pt-3 border-t border-zinc-800 bg-zinc-900/30">
        <div class="max-w-3xl mx-auto">

            <div
                class="flex items-end gap-3 bg-zinc-800 border border-zinc-700 rounded-2xl px-4 py-3 focus-within:border-violet-500 transition-colors duration-200">

                {{-- textarea --}}
                <textarea wire:model="input" wire:keydown.enter.prevent="send" rows="1" placeholder="Message LaraChat..."
                    class="flex-1 bg-transparent text-sm text-zinc-100 placeholder-zinc-500 resize-none outline-none leading-relaxed"
                    style="min-height: 28px; height: 28px;"></textarea>

                    {{-- Send button --}}
                <button wire:click="send"
                    class="cursor-pointer flex-shrink-0 w-8 h-8 rounded-xl bg-violet-600 hover:bg-violet-500 disabled:bg-zinc-700 disabled-opacity-50 disabled:cursor-not-allowed flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.269 20.876L5.999 12zm0 0h7.5" />
                    </svg>
                </button>
            </div>
            <p class="text-center text-xs text-zinc-600 mt-2">LaraChat can make mistakes. Always verify important info.
            </p>
        </div>

    </div>

</div>
