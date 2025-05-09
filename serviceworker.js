const CACHE_NAME = "mitraSahabat-cache-v1";
const urlsToCache = [
  "/",
  "/offline.html",
  "/assets/css/material-dashboard.css",
  "/assets/js/core/popper.min.js",
  "/assets/js/core/bootstrap.min.js",
  "/assets/js/core/perfect-scrollbar.min.js",
  "/assets/img/apple-icon.png",
  "/assets/img/favicon.png"
];


self.addEventListener("install", (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      return cache.addAll(urlsToCache);
    })
  );
});



self.addEventListener("fetch", (event) => {
  event.respondWith(
    caches.match(event.request).then((cachedResponse) => {
      // Jika ada respons di cache, gunakan itu
      if (cachedResponse) {
        return cachedResponse;
      }

      // Jika tidak ada di cache, coba ambil dari jaringan
      return fetch(event.request).catch(() => {
        // Jika fetch gagal (offline), tampilkan halaman offline
        if (event.request.mode === "navigate") {
          return caches.match("/offline.html");
        }
      });
    })
  );
});

self.addEventListener("activate", (event) => {
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((cache) => {
          if (cache !== CACHE_NAME) {
            return caches.delete(cache);
          }
        })
      );
    })
  );
});
