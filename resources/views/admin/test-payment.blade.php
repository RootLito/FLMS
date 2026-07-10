<x-layouts.app title="Test Payment">
    <div class="flex h-full w-full flex-col gap-4 rounded-xl">
        <div class="relative mb-4 w-full">
            <flux:heading size="xl" level="1">Test Payment</flux:heading>
            <flux:subheading size="lg" class="mb-6">
                Manage test payment for lessees.
            </flux:subheading>
            <flux:separator variant="subtle" />
        </div>

        <form action="{{ route('payment.send') }}" method="POST">
            @csrf

            <flux:card class="max-w-md space-y-6">
                <div>
                    <flux:heading size="lg">Send Payment Link</flux:heading>
                    <flux:text class="mt-2">
                        Enter the lessee's Gmail address to generate a secure PayMongo sandbox link and email it
                        directly.
                    </flux:text>
                </div>

                @if (session()->has('success'))
                    <div class="text-sm text-green-600 bg-green-50 p-3 rounded border border-green-200">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="text-sm text-red-600 bg-red-50 p-3 rounded border border-red-200">
                        {{ session('error') }}
                    </div>
                @endif

                <div>
                    <flux:input type="email" name="email" value="{{ old('email') }}" placeholder="lessee@gmail.com"
                        icon="envelope" label="Lessee Gmail Address" />
                    @error('email')
                        <span class="text-sm text-red-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-between items-center pt-2">
                    <flux:modal.trigger name="qr-ph-modal">
                        <flux:button variant="subtle" icon="qr-code">
                            Show QR Code
                        </flux:button>
                    </flux:modal.trigger>

                    <flux:button type="submit" variant="primary" icon="paper-airplane" color="emerald">
                        Send Payment
                    </flux:button>
                </div>
            </flux:card>
        </form>

        <flux:modal name="qr-ph-modal" class="min-w-[22rem] max-w-sm">
            <div class="space-y-6">
                <!-- Header & Instructions -->
                <div>
                    <flux:heading size="lg">Scan to test QR endpoint</flux:heading>

                    <flux:text class="mt-2">
                        Scan this test QR code using your mock banking app or device to simulate a QR Ph payment.
                    </flux:text>
                </div>

                <!-- QR Code Container -->
                <div
                    class="flex justify-center p-6 bg-zinc-50 dark:bg-zinc-900 rounded-xl border border-dashed border-zinc-300 dark:border-zinc-700">
                    <img src="https://assets.paymongo.com/images/qr_ph_placeholder.png"
                        onerror="this.src='https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=PayMongo%20QRPh%20Sandbox%20Test'"
                        alt="QR Ph Sandbox Test Code" class="w-48 h-48 mix-blend-multiply dark:mix-blend-normal" />
                </div>

                <!-- Footer Actions -->
                <div class="flex gap-2">
                    <flux:spacer />

                    <flux:modal.close>
                        <flux:button variant="ghost">Close</flux:button>
                    </flux:modal.close>
                </div>
            </div>
        </flux:modal>
    </div>
</x-layouts.app>
