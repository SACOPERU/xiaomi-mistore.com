<x-app-layout>

    @push('head')

            <!-- Javascript library. Should be loaded in head section -->
            <script
            src="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/stable/kr-payment-form.min.js"
            kr-public-key="{{config('services.izipay.public_key')}}"
            kr-post-url-success="{{route('paid.izipay')}}">
            </script>

            <!-- theme and plugins. should be loaded after the javascript library -->
            <!-- not mandatory but helps to have a nice payment form out of the box -->
            <link rel="stylesheet"
            href="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/ext/classic-reset.css">
            <script
            src="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/ext/classic.js">
            </script>

    @endpush

<div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-5 gap-6 container py-8">

    <div class="xl:col-span-3 ">
        <div class="bg-white rounded-lg shadow-lg px-6 py-4 mb-6">

            <p class="text-gray-700 uppercase"> <span class="font-semibold">Numero de orden :</span> Orden - 000{{$order->id}}</p>

        </div>

        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="grid grid-cols-2 gap-6 text-gray-700">
                    <div>
                        @if ($order->envio_type == 1)
                        <p class="text-lg fond-semibold uppercase">RECOJO EN :</p>
                        <p class="text-sm">{{$order->selected_store}}</p>

                        @else
                            <p  class="text-sm">Los productos seran enviados a: </p>
                            <p  class="text-sm">{{$order->address}}</p>
                            <p>{{$order->department->name}} - {{$order->city->name}} - {{$order->district->name}}</p>
                            <p  class="text-sm ">Ubigeo: {{$order->district_id}}</p>
                        @endif
                    </div>

                    <div>
                        <p class="text-lg fond-semibold uppercase">Datos de Contacto</p>

                        <p class="text-sm">Persona que recibira el pedido: {{$order->contact}}</p>
                        <p class="text-sm">Telefono de contacto: {{$order->phone}}</p>
                        <p class="text-sm">Documento de Identidad: {{$order->dni}}</p>
                    </div>

            </div>

        </div>

        <div class="bg-white rounded-lg shadow-lg p-6 text-gray-700 mb-6">
            <p class="text-lg font-semibold mb-4">Resumen</p>

            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th></th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @foreach ($items as $item)
                        @if (!in_array($item->name, ['ZONA 1', 'ZONA 2', 'ZONA 3']))
                            <tr>
                                <td>
                                    <div class="flex">
                                        <img class="h-15 w-20 object-cover mr-4" src="{{ $item->options->image }}" alt="">
                                        <article>
                                            <h1 class="font-bold">{{ $item->name }}</h1>
                                            <h1 class="font-bold">{{ $item->options->sku }}</h1>
                                            <div class="flex text-xs">
                                                @isset ($item->options->color)
                                                    Color: {{ __($item->options->color) }}
                                                @endisset

                                                @isset ($item->options->size)
                                                    Size: {{ __($item->options->size) }}
                                                @endisset
                                            </div>
                                        </article>
                                    </div>
                                </td>
                                <td class="text-center">
                                    S/ {{ $item->price }}
                                </td>
                                <td class="text-center">
                                    {{ $item->qty }}
                                </td>
                                <td class="text-center">
                                    S/ {{ $item->price * $item->qty }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>

            </table>

        </div>



        <div>
            <p class="text-sm font-semibold">
                Subtotal: S/ {{$order->total - $order->shipping_cost}}
            </p>

            <p class="text-sm font-semibold">
                Envio: S/ {{$order->shipping_cost}}
            </p>

            <p class="text-lg font-semibold uppercase text-red-600">
                Total: S/ {{$order->total}}
            </p>
        </div>

    </div>

    <div class="xl:col-span-2 ">

        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex justify-between items-center">
                <img class="h-8" src="{{ asset('img/pago.jpg') }}" alt="">
                <div class="text-gray-700 ">

                    <p class="text-sm font-semibold">
                        Subtotal: S/ {{$order->total - $order->shipping_cost}}
                    </p>

                    <p class="text-sm font-semibold">
                        Envio: S/ {{$order->shipping_cost}}
                    </p>

                    <p class="text-lg font-semibold uppercase text-red-600">
                        Total: S/ {{$order->total}}
                    </p>
                    <div>
                        <p class="mb-4">Seleciona el metodo de pago:</p>
                        <ul>
                            <li x-data="{open: false}">

                                <button x-on:click="open = !open "class="flex justify-center bg-red-500 py-2 w-full rounded-lg shadow">
                                    <h2 class=" text-center text-lg font-bold"></h2>
                                  <img class="h-8 "src="https://www.izipay.pe/_nuxt/dist/img/logo.8e6aa05.png" alt="">
                                </button>

                                <div class="pt-6 pb-4 flex justify-center" x-show='open' style="display: none">
                                            <!-- payment form -->
                                        <div class="kr-embedded" kr-form-token="{{$formToken}}">

                                            <!-- payment form fields -->
                                            <div class="kr-pan"></div>
                                            <div class="kr-expiry"></div>
                                            <div class="kr-security-code"></div>

                                            <!-- payment form submit button -->
                                            <button class="kr-payment-button"></button>

                                            <!-- error zone -->
                                            <div class="kr-form-error"></div>
                                        </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>

