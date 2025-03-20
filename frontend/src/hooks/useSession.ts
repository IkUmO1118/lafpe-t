import { UseSetSessionProps } from "../types";

export function useSetSession({ key, value }: UseSetSessionProps): void {
  return sessionStorage.setItem(key, value);
}

export function useRemoveSession(key: string): void {
  return sessionStorage.removeItem(key);
}

export function useGetSession(key: string): string {
  return sessionStorage.getItem(key)!;
}
