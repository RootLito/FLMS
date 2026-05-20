<?php

use function Livewire\Volt\{state};

state([
    'step' => 1,
    'totalSteps' => 6,
    'stepsInfo' => [
        1 => ['letter' => 'a', 'title' => 'Kind and Extent of Improvements'],
        2 => ['letter' => 'b', 'title' => 'Operation and Production'],
        3 => ['letter' => 'c', 'title' => 'Verification of Presence '],
        4 => ['letter' => 'd', 'title' => 'Case status of the area'],
        5 => ['letter' => 'e', 'title' => 'Remarks and Recommendation/s'],
        6 => ['letter' => 'f', 'title' => 'Signature and Photo'],
    ]
]);

$nextStep = function () {
    if ($this->step < $this->totalSteps) {
        $this->step++;
    }
};

$previousStep = function () {
    if ($this->step > 1) {
        $this->step--;
    }
};

?>
<flux:card class="w-full my-6 !p-0 overflow-hidden">
    <!-- TOP: Step Indicator Header -->
    <div class="p-6 border-b border-gray-200 bg-gray-50/50 dark:bg-zinc-800/50">
        <nav aria-label="Progress">
            <ol role="list"
                class="divide-y divide-gray-200 dark:divide-zinc-700 rounded-lg border border-gray-200 dark:border-zinc-700 md:flex md:divide-y-0 bg-white dark:bg-zinc-900">
                @foreach($stepsInfo as $index => $info)
                @php
                $isActive = $step === $index;
                $isCompleted = $step > $index;
                @endphp

                <li class="relative md:flex md:flex-1">
                    <div class="flex items-center w-full p-4 text-sm font-medium">
                        <!-- Circle Indicator Container -->
                        <span class="flex flex-shrink-0 items-center justify-center">
                            @if($isCompleted || $isActive)
                            <!-- Completed & Active Step: Emerald Base Theme -->
                            <span
                                class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-600 dark:bg-emerald-500 text-white font-semibold shadow-sm">
                                @if($isCompleted)
                                <flux:icon.check class="h-5 w-5 text-white" variant="mini" />
                                @else
                                {{ strtoupper($info['letter']) }}
                                @endif
                            </span>
                            @else
                            <!-- Upcoming Step -->
                            <span
                                class="flex h-8 w-8 items-center justify-center rounded-full border-2 border-gray-300 dark:border-zinc-600 text-gray-500 dark:text-zinc-400">
                                {{ strtoupper($info['letter']) }}
                            </span>
                            @endif
                        </span>

                        <!-- Text Labels (Color changes based on step status) -->
                        <span class="ml-4 flex min-w-0 flex-col">
                            {{-- <span
                                class="text-xs font-semibold tracking-wide uppercase {{ $isActive || $isCompleted ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-500 dark:text-zinc-400' }}">
                                Step {{ strtoupper($info['letter']) }}
                            </span> --}}
                            <span
                                class="text-sm font-medium line-clamp-1 {{ $isActive || $isCompleted ? 'text-emerald-700 dark:text-emerald-300' : 'text-zinc-500 dark:text-zinc-400' }}"
                                title="{{ $info['title'] }}">
                                {{ $info['title'] }}
                            </span>
                        </span>
                    </div>

                    <!-- Decorative Chevron Separator between steps -->
                    @if(!$loop->last)
                    <div class="absolute top-0 right-0 hidden h-full w-5 md:block" aria-hidden="true">
                        <svg class="h-full w-full text-gray-300 dark:text-zinc-700" viewBox="0 0 22 80" fill="none"
                            preserveAspectRatio="none">
                            <path d="M0 -2L20 40L0 82" vector-effect="non-scaling-stroke" stroke="currentcolor"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                    @endif
                </li>
                @endforeach
            </ol>
        </nav>
    </div>

    <!-- MAIN MIDDLE DIV: Actual Input Content -->
    <div class="p-8 min-h-[300px]">
        @if ($step === 1)
        <x-inspection.part-a />
        @elseif ($step === 2)
        <x-inspection.part-b />
        @elseif ($step === 3)
        <x-inspection.part-c />
        @elseif ($step === 4)
        <x-inspection.part-d />
        @elseif ($step === 5)
        <x-inspection.part-e />
        @elseif ($step === 6)
        <x-inspection.part-f />
        @endif
    </div>

    <!-- BOTTOM DIV: Navigation Controls -->
    <div
        class="p-6 bg-gray-50 dark:bg-zinc-800/50 border-t border-gray-200 dark:border-zinc-700 flex justify-between items-center">
        <!-- Previous Button (Turns gray and disables on page 1) -->
        <flux:button variant="primary" :color="$step === 1 ? '' : 'emerald'" wire:click="previousStep"
            :disabled="$step === 1" icon="chevron-left">
            Previous
        </flux:button>

        <!-- Step counter display -->
        <flux:text font-weight="medium" inset="none" class="text-gray-500 dark:text-zinc-400">
            Step {{ $step }} of {{ $totalSteps }}
        </flux:text>

        <!-- Next Button (Turns gray and disables on the last page) -->
        <flux:button variant="primary" :color="$step === $totalSteps ? '' : 'emerald'" wire:click="nextStep"
            :disabled="$step === $totalSteps" icon-trailing="chevron-right">
            Next
        </flux:button>
    </div>
</flux:card>