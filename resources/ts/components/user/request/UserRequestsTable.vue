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
                @click="fetchRequests"
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
                    :loading="requests_loading"
                >
                    <template #[`item.image_url`]="{ item }">
                        <image-preview
                            :src="getImageURL(item.type, item.image_url)"
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
                            @click="removeRequest(item)"
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
import { defineComponent } from '@vue/composition-api';

import RequestAddDialog from '@/components/user/request/RequestAddDialog.vue';
import IconTooltip from '@/components/defaults/IconTooltip.vue';
import DateChip from '@/components/defaults/DateChip.vue';
import ImagePreview from '@/components/defaults/ImagePreview.vue';

import { useRequestTable } from '@/components/admin/request/AdminRequestsPage.vue';
import { useRequests } from '@/store/requests';

export default defineComponent({
    components: {
        RequestAddDialog,
        DateChip,
        IconTooltip,
        ImagePreview,
    },
    setup(props, vm) {
        const {
            requests,
            requests_loading,
            processing_request_id,
            fetchRequests,
            removeRequest,
        } = useRequests();

        return {
            ...useRequestTable(vm),
            requests,
            requests_loading,
            processing_request_id,
            fetchRequests,
            removeRequest,
        };
    },
    created() {
        this.fetchRequests();
    }
});
</script>