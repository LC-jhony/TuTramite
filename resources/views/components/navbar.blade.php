   <div class="w-full text-gray-700 dark:text-gray-200 dark:bg-gray-800 bg-white">
       <div x-data="{ open: false }"
           class="flex flex-col max-w-screen-xl px-4 py-4 mx-auto md:items-center md:justify-between md:flex-row md:px-6 lg:px-8">
           <div class="flex flex-row items-center justify-between">
               {{ $logo }}

           </div>
           <nav :class="{ 'flex': open, 'hidden': !open }"
               class="flex-col flex-grow hidden pb-4 md:pb-0 md:flex md:justify-center md:flex-row">
               {{ $slot }}
           </nav>
           <div>
               {{ $login }}
           </div>
       </div>
   </div>
