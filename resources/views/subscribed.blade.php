<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ auth()->user()->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(auth()->user()->subscribed('Assinatura mensal'))
                        <p>You are subscribed to our service. (1)</p>
                    @endif

                    @if(auth()->user()->subscribedToProduct('prod_Reubol5O1Ab3Zv', 'Assinatura mensal'))
                        <p>You are subscribed to our service. (2)</p>
                    @endif

                    @if(auth()->user()->subscribedToPrice('price_1QlamAH8Rnnrgm85c7c97kS6', 'Assinatura mensal'))
                        <p>You are subscribed to our service. (3)</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
