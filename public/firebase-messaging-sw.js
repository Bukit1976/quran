// public/firebase-messaging-sw.js
importScripts('https://www.gstatic.com/firebasejs/10.12.2/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.12.2/firebase-messaging-compat.js');

firebase.initializeApp({
    apiKey: "AIzaSyAs0Ma5FvLJKWi-fcW2JV2_XcneBc7DVtQ",
    authDomain: "hafalan-alquran.firebaseapp.com",
    projectId: "hafalan-alquran",
    storageBucket: "hafalan-alquran.firebasestorage.app",
    messagingSenderId: "508902061866",
    appId: "1:508902061866:web:80932deab28134d73c9053",
    measurementId: "G-F6VZ2YRSH0"
});

const messaging = firebase.messaging();

// Handle background messages
messaging.onBackgroundMessage((payload) => {
    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: '/Logo/LogoNew.png',
        badge: '/Logo/LogoNew.png',
        requireInteraction: true,
        tag: 'prayer-time'
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});
