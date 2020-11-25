export type ConfirmOptions = {
    color: string;
    width: number;
    zIndex: number;
}

export type ConfirmType = (title: string, message?: string, options?: ConfirmOptions) => Promise<boolean>;