<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div>
    <h2 class="text-xl font-bold text-gray-800 mb-2">E. Remarks and Recommendation/s</h2>
    <flux:separator class="my-6" />

    <div class="space-y-6">
        <!-- Remarks Section -->
        <div class="w-1/2 flex flex-col gap-2">
            <flux:label> Remarks and Recommendation/s</flux:label>
            <flux:textarea placeholder="Enter detailed observations and findings..." rows="10"/>
        </div>

        <!-- Recommendation Section -->
        {{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="w-full">
                <flux:label>Proposed Action/Recommendation</flux:label>
                <flux:textarea placeholder="State specific recommendations for the area..." rows="4" />
            </div>

            <!-- Meta Information (Status/Priority) -->
            <div class="flex flex-col gap-y-4">
                <div class="w-full">
                    <flux:label>Application Status Recommendation</flux:label>
                    <flux:radio.group class="flex flex-col gap-2 mt-1">
                        <flux:radio label="For Approval" name="status_rec" />
                        <flux:radio label="For Further Evaluation" name="status_rec" />
                        <flux:radio label="For Rejection/Disapproval" name="status_rec" />
                    </flux:radio.group>
                </div>

                <div class="w-full">
                    <flux:input label="Action Officer" placeholder="Name" size="sm" />
                </div>
            </div>
        </div> --}}
    </div>
</div>