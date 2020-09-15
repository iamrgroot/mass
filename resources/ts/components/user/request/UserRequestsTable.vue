<template>
    <v-card class="ma-3">
        <v-card-title>
            <span>Requests</span>
            <v-spacer />
            <v-btn
                outlined
                class="ma-2"
                @click="add_dialog = true"
            >
                New
            </v-btn>
            <v-btn
                icon
                class="ma-2"
                @click="fetch"
            >
                <v-icon>$mdiRefresh</v-icon>
            </v-btn>
        </v-card-title>
        <v-divider class="mx-3" />
        <v-card-text>
            <v-fade-transition mode="out-in">
                <v-data-table
                    :headers="headers"
                    :items="requests"
                    :loading="loading"
                >
                    <template #[`item.image_url`]="{ item }">
                        <image-preview
                            :src="getImageURL(item)"
                            right
                        />
                    </template>
                    <template #[`item.type`]="{ value }">
                        {{ itemString(value) }}
                    </template>
                    <template #[`item.created_at`]="{ value }">
                        <date-chip :date="value" />
                    </template>
                    <template #[`item.updated_at`]="{ value }">
                        <date-chip :date="value" />
                    </template>
                    <template #[`item.status`]="{ value }">
                        <icon-tooltip
                            :icon="value.icon"
                            :text="value.text"
                            :color="value.color"
                        />
                    </template>
                    <template #[`item.actions`]="{ item }">
                        <v-icon
                            v-if="item.created_by_current_user"
                            color="error"
                            class="ml-3"
                            @click="remove(item)"
                        >
                            $mdiDelete
                        </v-icon>
                    </template>
                </v-data-table>
            </v-fade-transition>
        </v-card-text>

        <request-add-dialog v-model="add_dialog" />
    </v-card>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { request_store } from '@/store/request';
import { getRequests, deleteRequest } from '@/api/request';
import { Request } from '@/types/Requests';
import { DataTableHeader } from 'vuetify';
import RequestAddDialog from '@/components/user/request/RequestAddDialog.vue';
import IconTooltip from '@/components/defaults/IconTooltip.vue';
import DateChip from '@/components/defaults/DateChip.vue';
import ImagePreview from '@/components/defaults/ImagePreview.vue';
import { ItemType } from '@/enums/ItemType';
import { getImageURL } from '@/helpers/images';

@Component({
    components: {
        RequestAddDialog,
        DateChip,
        IconTooltip,
        ImagePreview,
    }
})
export default class UserRequestsTable extends Vue {
    private loading = false;
    private add_dialog = false;
    private request_processing = -1;
    private headers: DataTableHeader[] = [
        { text: '', value: 'image_url' },
        { text: 'Type', value: 'type' },
        { text: 'Name', value: 'text' },
        { text: 'Created at', value: 'created_at' },
        { text: 'Updated at', value: 'updated_at' },
        { text: 'Status', value: 'status' },
        { text: '', value: 'actions', width: '100px', sortable: false, align: 'end' },
    ];

    get requests(): Request[] {
        return request_store.requests;
    }
    set requests(requests: Request[]) {
        request_store.requests = requests;
    }

    created(): void {
        this.fetch();
    }

    async fetch(): Promise<void> {
        this.loading = true;
        this.requests = await getRequests();
        this.loading = false;
    }
    async remove(request: Request): Promise<void> {
        this.request_processing = request.id;

        await deleteRequest(request.id);

        this.requests.splice(
            this.requests.findIndex(old_item => {
                return request.id === old_item.id;
            }),
            1
        );

        this.request_processing = -1;
    }
    itemString(type: ItemType): string {
        return type === ItemType.Movie ? 'Movie' : 'Serie';
    }
    getImageURL(item: Request): string {
        return getImageURL(item.type, item.image_url);
    }
}
</script>