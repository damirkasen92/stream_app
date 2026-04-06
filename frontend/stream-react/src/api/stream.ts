import api from "./axiosConfig.ts";

export async function createStream(data: Record<string, string>) {
    return await api.post("/streams", data);
}
