import type { CapacitorConfig } from '@capacitor/cli';

const config: CapacitorConfig = {
    appId: 'com.bukityetti.hafalquran',
    appName: 'HafalQuran',
    webDir: 'public',
    server: {
        url: 'https://alquran.bukityetti.com',
        cleartext: false
    },
    android: {
        allowMixedContent: true
    },
    cordova: {},
    plugins: {
        LocalNotifications: {
            smallIcon: 'ic_notification',
            iconColor: '#10b981'
        }
    }
};

export default config;
