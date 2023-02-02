<template>
    <div class="text-white mb-8">
        <div v-if="hasError" class="flex justify-between py-4 px-8 my-2 bg-[#313131]  text-[#e2e2e2]">
            <p v-for="(error, eIndex) in errors" :key="eIndex" class="font-sans">{{ error }}</p>
            <button class="font-bold" @click="hasError = !hasError">&#10005;</button>
        </div>
        <div id="places-input" class="text-gray-800">
            <!-- choose a city -->
            <div class="relative text-lg">
                <button
                    class="flex items-center justify-between px-3 py-2 bg-white w-full border border-gray-500 rounded-lg"
                    @click="toggle"
                    @blur="visible = false"
                >
                    <span>{{ selected ?? 'Choose a City (☝ ՞ਊ ՞)☝' }}</span>
                    <svg
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        class="h-4 w-4 transform transition-transform duration-200 ease-in-out"
                        :class="visible ? 'rotate-180' : 'rotate-0'"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 9l-7 7-7-7"
                        />
                    </svg>
                </button>
                <transition
                    enter-active-class="transform transition duration-500 ease-custom"
                    enter-class="-translate-y-1/2 scale-y-0 opacity-0"
                    enter-to-class="translate-y-0 scale-y-100 opacity-100"
                    leave-active-class="transform transition duration-300 ease-custom"
                    leave-class="translate-y-0 scale-y-100 opacity-100"
                    leave-to-class="-translate-y-1/2 scale-y-0 opacity-0"
                >
                    <ul
                        v-show="visible"
                        class="absolute w-full left-0 right-0 mb-4 bg-white divide-y rounded-lg shadow-lg overflow-hidden"
                    >
                        <li
                            v-for="(option, index) in placesList"
                            :key="index"
                            class="px-3 py-2 transition-colors duration-300 hover:bg-gray-200"
                            @click="select(option)"
                        >
                            {{ option }}
                        </li>
                    </ul>
                </transition>
            </div>
        </div>
        <div class="flex flex-col pt-12" v-if="loading">
            <div class="m-auto">
                <div class="fulfilling-square-spinner">
                    <div class="spinner-inner"></div>
                </div>
            </div>
        </div>
        <div
            v-if="selected && !loading && !hasError"
            id="weather-container"
            class="font-sans md:w-128 max-w-lg rounded-lg overflow-hidden bg-gray-900 shadow-lg mt-8"
        >
            <div id="current-weather" class="flex items-center justify-evenly lg:justify-center px-8 py-8 lg:px-6">
                <div class="flex flex-col md:flex-row items-center">
                    <div>
                        <div class="text-2xl font-semibold">{{ weather.name }}</div>
                        <div class="text-5xl font-semibold">{{ Math.round(weather.main.temp) }}°C</div>
                        <div>Feels like {{ Math.round(weather.main.feels_like) }}°C</div>
                        <div>{{ getDay() }}</div>
                    </div>
                    <div class="md:mx-3">
                    </div>
                </div>
                <div class="md:ml-5">
                    <div class="font-semibold">{{ weather.summary }} - {{ weather.description }}</div>
                    <img :src="weather.icon" class="w-100 h-100"/>
                    <div class="font-semibold italic w-fit">{{ personalization[weather.summary] }}</div>
                </div>
            </div>
            <!-- end current-weather -->

            <div id="places-to-go" class="text-sm bg-gray-800 px-6 py-8 overflow-hidden">
                <div
                    class="flex items-center px-6 py-6"
                    v-for="(place, index) in places"
                    :key="index"
                >
                    <div class="flex items-center flex-col -space-x-1 overflow-hidden">
                        <img class="w-8 h-8" :src="category.icon.prefix + 120 + category.icon.suffix"
                             v-for="(category, catindex) in place.categories" :key="catindex"/>
                    </div>

                    <div class="w-3/4 text-lg text-gray-200 px-5">
                        {{ place.name }}
                    </div>

                    <div class=" text-right">
                        <div>Location:</div>
                        <div>{{ place.location.address }}</div>
                    </div>
                </div>

            </div>
            <!-- end future-weather -->
        </div>
        <!-- end weather-container -->
    </div>
</template>
<script lang="ts">

import {ref} from 'vue'
import axios from "axios";
import {has} from "lodash/object";

export default {
    methods: {
        has() {
            return has
        }
    },
    setup() {
        const errors = ref([])
        const hasError = ref(false)
        const personalization = ref({
            'Clouds': 'It may rain today. Dont forget that umbrella, you never know your Tracy McConnell might need it.',
            'Snow': 'Brrr... saké anyone?'
        });
        const loading = ref(false);
        const openWeatherIconPath = "http://openweathermap.org/img/wn/";
        const weather = ref({name: '', main: {feels_like: 0, temp: 0}, summary: '', icon: '', description: ''});
        const places = ref({});
        const placesList: Array<string> = ['Tokyo', 'Yokohama', 'Kyoto', 'Osaka', 'Sapporo', 'Nagoya'];
        const visible = ref(false);
        const toggle = () => {
            visible.value = !visible.value;
        };

        const toggleLoader = () => {
            loading.value = !loading.value;
        };

        const selected = ref(null);
        const select = (choice: string) => {
            toggleLoader();
            selected.value = choice;
            fetchPlaceDetails().then(() => fetchWeatherDetails());
        };

        async function fetchPlaceDetails() {
            try {
                await axios.get('http://localhost:8000/api/places', {params: {city: selected.value}})
                    .then(res => {
                        places.value = res.data.results;
                    });
            } catch (error) {
                errors.value.push(error.response.data)
                hasError.value = true
            }
        }

        async function fetchWeatherDetails() {
            try {
                await axios.get('http://localhost:8000/api/weather-forecast', {params: {city: selected.value}})
                    .then(res => {
                        weather.value = res.data;
                        weather.value.summary = res.data.weather[0].main;
                        weather.value.description = res.data.weather[0].description;
                        weather.value.icon = openWeatherIconPath + res.data.weather[0].icon + ".png";

                        toggleLoader();
                    });
            } catch (error) {
                errors.value.push(error.response.data)
                hasError.value = true
                toggleLoader()
            }
        }

        const getDay = () => {
            const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            return days[new Date().getDay()];
        };

        return {
            errors,
            hasError,
            loading,
            personalization,
            places,
            placesList,
            selected,
            visible,
            weather,
            getDay,
            select,
            toggle,
        };
    },
}
</script>
<style scoped>
.ease-custom {
    transition-timing-function: cubic-bezier(.61, -0.53, .43, 1.43);
}

.fulfilling-square-spinner, .fulfilling-square-spinner * {
    box-sizing: border-box;
}

.fulfilling-square-spinner {
    height: 50px;
    width: 50px;
    position: relative;
    border: 4px solid #074670;
    animation: fulfilling-square-spinner-animation 4s infinite ease;
}

.fulfilling-square-spinner .spinner-inner {
    vertical-align: top;
    display: inline-block;
    background-color: rgb(17 24 39 / 1);
    width: 100%;
    opacity: 1;
    animation: fulfilling-square-spinner-inner-animation 4s infinite ease-in;
}

@keyframes fulfilling-square-spinner-animation {
    0% {
        transform: rotate(0deg);
    }

    25% {
        transform: rotate(180deg);
    }

    50% {
        transform: rotate(180deg);
    }

    75% {
        transform: rotate(360deg);
    }

    100% {
        transform: rotate(360deg);
    }
}

@keyframes fulfilling-square-spinner-inner-animation {
    0% {
        height: 0%;
    }

    25% {
        height: 0%;
    }

    50% {
        height: 100%;
    }

    75% {
        height: 100%;
    }

    100% {
        height: 0%;
    }
}
</style>
