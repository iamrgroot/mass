import { VuexModule, Module, Mutation } from 'vuex-module-decorators';
import { Notification } from '@/types/Notification';

@Module({ namespaced: true })
class Notifications extends VuexModule {
    public notifications: Array<Notification> = [];

    @Mutation
    public notify(notification: Notification): void {
        if (! notification.id) notification.id = Date.now();
        if (! notification.timeout) notification.timeout = 5000;
        if (! notification.color) notification.color = 'primary';

        this.notifications.push(notification);
    }
    @Mutation
    public remove(notification_id: number): void {
        this.notifications.splice(
            this.notifications.findIndex(item => {
                return item.id === notification_id;
            }),
            1
        );
    }
}
export default Notifications;