const CACHE_NAME = "hafalquran-v1";
const urlsToCache = [
    "/dashboard",
    "/quran",
    "/hafalan",
    "/murajaah",
    "/tes",
    "/statistik",
];

// Install Service Worker
self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => cache.addAll(urlsToCache)),
    );
});

// Fetch assets
self.addEventListener("fetch", (event) => {
    event.respondWith(
        caches
            .match(event.request)
            .then((response) => response || fetch(event.request)),
    );
});
