export type Torrent = {
    id: number;
    status: number;
    status_icon: string;
    name: string;
    error_string: string | null;
    eta: number;
    rate_download: number;
    rate_upload: number;
    size_when_done: number;
    percent_done: number;
}