<x-layouts.app :title="__('Events')">
    <div class="container mx-auto p-6">
         <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @if ($event->image_id)
               <div class="space-y-6">
                </div>
            @endif

            <div class="space-y-6">
                <p>{{ $event->date->format('l d F Y') }}</p>
            </div>
         </div>
    </div>
</x-layouts.app>
