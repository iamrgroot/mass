export type Torrent = {
    id: number;
    status: number;
    name: string;
    error_string: string | null;
    eta: number;
    rate_download: number;
    rate_upload: number;
    size_when_done: number;
    percent_done: number;
}