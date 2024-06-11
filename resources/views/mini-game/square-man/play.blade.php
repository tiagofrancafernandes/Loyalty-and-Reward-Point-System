</body>
</html>
<!DOCTYPE html>
<html lang="en" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Alpine JS</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <script src="https://cdn.tailwindcss.com"></script>

        {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}
        @vite([
            'resources/js/mini-games/square-man/app.js',
        ])

        <script>
            tailwind.config = {
                darkMode: 'selector',
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Figtree', 'ui-sans-serif', 'system-ui', 'sans-serif', "Apple Color Emoji", "Segoe UI Emoji"],
                        }
                    }
                }
            }
        </script>
    </head>
    <body
        class="antialiased bg-white dark:bg-black"
        x-data="gameData"
    >
        <div
            class="w-full"
        >
            <div class="w-[35%] mx-auto sm:w-3/12 md:w-48 lg:mx-auto my-4">
                <div class="flex flex-col items-start justify-between mb-4">
                    <h5
                        class="text-md font-bold leading-none text-gray-900 dark:text-white"
                    >
                        Score: <span x-text="score"></span>
                    </h5>
                    <h5
                        class="text-md font-bold leading-none text-gray-900 dark:text-white"
                    >
                        Time left: <span x-text="timeLeft"></span>
                    </h5>
                    <h5
                        class="text-md font-bold leading-none text-gray-900 dark:text-white"
                        x-bind:class="{
                            'pt-1': !topMessage,
                        }"
                    >
                        <span x-text="topMessage"></span>
                    </h5>
               </div>

                <div
                    class="grid gap-1 relative"
                    x-bind:class="[
                        `grid-cols-${width}`,
                        `grid-rows-${height}`,
                    ]"
                    x-on:click="whenClickOnGameFild"
                >
                    <div
                        class="absolute opacity-1 w-full mx-auto my-auto z-30"
                        x-bind:class="{
                            hidden: !modalMessage?.showModal,
                            block: modalMessage?.showModal,
                        }"
                    >
                        <div
                            class="my-auto items-center justify-center pt-6 z-30"
                            x-bind:class="{
                                flex: modalMessage?.showModal,
                                hidden: !modalMessage?.showModal,
                            }"
                        >
                            <div class="bg-gray-200 p-4 rounded-lg">
                                <div class="w-full mb-2">
                                    <div class="text-center" x-html="modalMessage.line1"></div>
                                    <div class="text-center" x-html="modalMessage.line2"></div>
                                    <div class="text-center" x-html="modalMessage.line3"></div>
                                </div>

                                <div class="w-full">
                                    <div class="flex items-center justify-center">
                                        <button
                                            type="button"
                                            x-on:click="startNewGame"
                                            class="px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                        >
                                            New game

                                            <svg class="w-3 h-3 text-white ms-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.75 8a4.5 4.5 0 0 1-8.61 1.834l-1.391.565A6.001 6.001 0 0 0 14.25 8 6 6 0 0 0 3.5 4.334V2.5H2v4l.75.75h3.5v-1.5H4.352A4.5 4.5 0 0 1 12.75 8z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <template
                        x-for="square in fieldSize"
                    >
                        <div
                            class="flex items-center justify-center rounded-sm border border-gray-500 px-2 w-5 h-5"
                            x-bind:class="{
                                'bg-slate-900': position !== square,
                                'bg-slate-600': position === square,
                                'opacity-25': !canPlay,
                            }"
                        >
                            <div
                                class="text-white"
                                x-html="giftContentFor(square)"
                            ></div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="flex mx-auto items-center justify-center">
                <div class="w-full max-w-md bg-white border border-gray-200 mb-3 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 p-4">
                    <div class="flex flex-1 items-center justify-between">
                        <div
                            class="text-gray-900 dark:text-white"
                        >
                            <div>
                                <span class="font-semibold">Player name:</span>
                            </div>
                            <span
                                x-show="!editPlayerName"
                                x-text="playerName"
                            ></span>

                            <input
                                x-show="editPlayerName"
                                type="text"
                                x-ref="playerNameInput"
                                x-bind:value="playerName"
                                placeholder="Player name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg ring-0 focus:ring-0 dark:focus:ring-0 focus:ring-blue-500 focus:border-blue-500 block w-full p-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                x-on:keydown.enter="confirmEditName"
                            >
                        </div>

                        <div>
                            <button
                                type="button"
                                x-show="!editPlayerName"
                                x-on:click="editPlayerName = !editPlayerName"
                                class="px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            >
                                Edit player name

                                <svg class="w-3 h-3 text-white ms-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!-- Font Awesome Free 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) --><path d="M402.6 83.2l90.2 90.2c3.8 3.8 3.8 10 0 13.8L274.4 405.6l-92.8 10.3c-12.4 1.4-22.9-9.1-21.5-21.5l10.3-92.8L388.8 83.2c3.8-3.8 10-3.8 13.8 0zm162-22.9l-48.8-48.8c-15.2-15.2-39.9-15.2-55.2 0l-35.4 35.4c-3.8 3.8-3.8 10 0 13.8l90.2 90.2c3.8 3.8 10 3.8 13.8 0l35.4-35.4c15.2-15.3 15.2-40 0-55.2zM384 346.2V448H64V128h229.8c3.2 0 6.2-1.3 8.5-3.5l40-40c7.6-7.6 2.2-20.5-8.5-20.5H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V306.2c0-10.7-12.9-16-20.5-8.5l-40 40c-2.2 2.3-3.5 5.3-3.5 8.5z"></path></svg>
                            </button>

                            <span
                                x-show="editPlayerName"
                                class="text-gray-900 dark:text-white"
                            >Press enter to confirm</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-8/12 lg:w-48 lg:mx-auto my-4">
                <div class="flex items-center justify-center">
                    <button
                        type="button"
                        x-on:click="startNewGame"
                        class="px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >
                        New game

                        <svg class="w-3 h-3 text-white ms-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12.75 8a4.5 4.5 0 0 1-8.61 1.834l-1.391.565A6.001 6.001 0 0 0 14.25 8 6 6 0 0 0 3.5 4.334V2.5H2v4l.75.75h3.5v-1.5H4.352A4.5 4.5 0 0 1 12.75 8z"></path>
                        </svg>
                    </button>
                </div>
                <input
                    class="bg-transparent text-transparent w-4 h-4 ring-0 focus:ring-0 active:ring-0 focus:outline-none outline-none focus:ring-none"
                    x-ref="gameControl"
                    x-on:keyup.prevent.capture="gameControlKeyUpAction"
                    x-on:keydown.prevent.capture="gameControlKeyDownAction"
                    type="text"
                    placeholder=""
                >
            </div>

            <div class="w-10/12 lg:w-8/12 mx-auto px-4 py-2 flex items-center justify-center">
                <div
                    class="w-full max-w-md bg-white border border-gray-200 mb-3 rounded-lg shadow sm:p-4 sm:pb-2 dark:bg-gray-800 dark:border-gray-700"
                >
                    <div
                        class="mx-auto items-center justify-center px-4 pb-2"
                        x-bind:class="{
                            flex: highScoreObject?.score,
                            hidden: !highScoreObject?.score,
                        }"
                    >
                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                            <div class="flex-row">
                                <span class="text-sm">High score</span>
                            <span
                                class="flex items-center justify-center rounded-md border border-gray-500 px-2 bg-slate-600"
                                x-text="highScoreObject?.score"></span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mb-4">
                        <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Latest Scores</h5>
                        <a href="#" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">
                            View all
                        </a>
                   </div>
                   <div class="flow-root">
                        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                            <template
                                x-for="scoreItem in latestScores"
                            >
                                <li class="py-2 sm:py-3">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 hidden">
                                            <img class="w-8 h-8 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-1.jpg" alt="Neil image">
                                        </div>
                                        <div class="flex-1 min-w-0 ms-4">
                                            <p
                                                class="text-sm font-medium text-gray-900 truncate dark:text-white"
                                                x-text="scoreItem.name"
                                            ></p>
                                            <div class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                <div class="grid grid-flow-col justify-stretch">
                                                    <div><span x-text="(new Date(scoreItem.date)).toLocaleDateString()"></span></div>
                                                    <div>GRID <span x-text="scoreItem.grid"></span></div>
                                                    <div>Time: <span x-text="scoreItem.timeLimit"></span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                            <div class="flex-row">
                                                <span class="text-sm">Score</span>
                                            <span
                                                class="flex items-center justify-center rounded-md border border-gray-500 px-2 bg-slate-600"
                                                x-text="scoreItem.score"></span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </template>
                        </ul>
                   </div>
                </div>
            </div>
        </div>
    </body>
</html>
