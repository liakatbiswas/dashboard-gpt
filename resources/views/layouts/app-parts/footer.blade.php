<footer class="footer">
    <div class="app-muted flex flex-col items-center justify-between gap-2 px-4 py-5 text-center text-xs sm:flex-row sm:px-6 sm:text-start lg:px-8">
        <p>&copy; {{ date('Y') }} {{ $siteSettings?->site_title ?: 'Name of Institution' }}. All rights reserved.</p>
        <p>Developed by <a href="https://liakatbiswas.com" target="_blank" rel="noopener" class="font-medium hover:underline">Liakat Biswas</a></p>
    </div>
</footer>
