<template>
    <div class="text-white mb-8">
        <div class="places-input text-gray-800">
            <input type="search" id="address" placeholder="Choose a city..." />
            <p>
                Selected:
                <strong id="address-value">none</strong>
            </p>
        </div>
        <div
            class="weather-container font-sans md:w-128 max-w-lg rounded-lg overflow-hidden bg-gray-900 shadow-lg mt-8"
        >
            <div class="current-weather flex items-center justify-between px-6 py-8">
                <div class="flex flex-col md:flex-row items-center">
                    <div>
                        <div class="text-5xl font-semibold">30°C</div>
                        <div>Feels like 30°C</div>
                    </div>
                    <div class="md:mx-5">
                        <div class="font-semibold"></div>
                        <div></div>
                    </div>
                </div>
                <div>

                    <img  width="90px" height="90px" />
                </div>
            </div>
            <!-- end current-weather -->

            <div class="future-weather text-sm bg-gray-800 px-6 py-8 overflow-hidden">\
                <div

                    class="flex items-center"
                >

                    <div class="w-1/6 text-lg text-gray-200">Wednesday</div>
                    <div class="w-4/6 px-4 flex items-center">
                        <div>

                        </div>

                        <div class="ml-3">Description</div>
                    </div>
                    <div class="w-1/6 text-right">
                        <div>°C</div>
                        <div>°C</div>
                    </div>
                </div>
            </div>
            <!-- end future-weather -->
        </div>
        <!-- end weather-container -->
    </div>
</template><!--
<script lang="ts">
</script>
-->
