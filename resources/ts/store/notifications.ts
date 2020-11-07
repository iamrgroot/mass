import { reactive, toRefs } from '@vue/composition-api';

import { Notification } from '@/types/Notification';

export const useNotifications = () => {
    const notification_store = reactive({
        notifications: [] as Notification[],
    });

    const notify = (notification: Notification): void => {
        if (! notification.id) notification.id = Date.now();
        if (! notification.timeout) notification.timeout = 5000;
        if (! notification.color) notification.color = 'primary';

        notification_store.notifications.push(notification);
    };

    const removeNotification = (notification_id: number): void => {
        notification_store.notifications.splice(
            notification_store.notifications.findIndex(item => {
                return item.id === notification_id;
            }),
            1
        );
    };
    return {
        ...toRefs(notification_store),
        notify,
        removeNotification,
    };
};