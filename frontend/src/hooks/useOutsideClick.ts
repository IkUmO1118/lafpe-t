import { useEffect, useRef, RefObject } from "react";

// Define the handler function type
type Handler = () => void;

export function useOutsideClick<T extends HTMLElement = HTMLElement>(
  handler: Handler,
  listenCapturing: boolean = true,
): RefObject<T> {
  const ref = useRef<T>(null);

  useEffect(
    function () {
      function handleClick(e: MouseEvent): void {
        if (ref.current && !ref.current.contains(e.target as Node)) {
          handler();
        }
      }

      document.addEventListener("click", handleClick, listenCapturing);

      return () =>
        document.removeEventListener("click", handleClick, listenCapturing);
    },
    [handler, listenCapturing],
  );

  return ref as RefObject<T>;
}
