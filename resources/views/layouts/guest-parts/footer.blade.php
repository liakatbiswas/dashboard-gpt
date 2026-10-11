<footer class="mt-auto border-t border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
  <div class="mx-auto w-full max-w-6xl px-4 py-12 sm:px-6 lg:px-8 xl:max-w-7xl xl:px-12 xl:py-16">

    <div class="grid gap-10 md:grid-cols-3 xl:gap-16">
      <div>
        <a href="{{ route('home') }}" class="inline-flex items-center">
          <img src="{{ asset('assets/images/logo-dark.png') }}" class="h-7 w-auto xl:h-8 dark:hidden" alt="Logo">
          <img src="{{ asset('assets/images/logo-light.png') }}" class="hidden h-7 w-auto xl:h-8 dark:block" alt="Logo">
        </a>
        <p class="mt-4 max-w-xs text-sm leading-relaxed text-gray-600 dark:text-gray-400 xl:text-base">
          Helping students learn with confidence, curiosity and care.
        </p>
      </div>

      <div>
        <h3 class="text-sm font-semibold xl:text-base">Quick links</h3>
        <ul class="mt-4 space-y-3 text-sm text-gray-600 dark:text-gray-400 xl:mt-5 xl:space-y-4 xl:text-base">
          <li><a href="#about" class="transition-colors hover:text-indigo-600 dark:hover:text-indigo-400">About</a></li>
          <li><a href="#experience"
              class="transition-colors hover:text-indigo-600 dark:hover:text-indigo-400">Experience</a></li>
          <li><a href="#contact" class="transition-colors hover:text-indigo-600 dark:hover:text-indigo-400">Contact</a>
          </li>
        </ul>
      </div>

      <div>
        <h3 class="text-sm font-semibold xl:text-base">Contact</h3>
        <ul class="mt-4 space-y-3 text-sm text-gray-600 dark:text-gray-400 xl:mt-5 xl:space-y-4 xl:text-base">
          <li><a href="mailto:teacher@example.com"
              class="transition-colors hover:text-indigo-600 dark:hover:text-indigo-400">liakatbiswas@gmail.com</a></li>
          <li><a href="tel:+8801700000000"
              class="transition-colors hover:text-indigo-600 dark:hover:text-indigo-400">01571-719052</a></li>
        </ul>
      </div>
    </div>

    <div
      class="mt-10 border-t border-gray-200 pt-6 text-center text-xs text-gray-500 dark:border-gray-800 sm:text-left xl:mt-12 xl:pt-8 xl:text-sm">
      &copy; {{ date('Y') }} Liakat Biswas. All rights reserved.
    </div>
  </div>
</footer>