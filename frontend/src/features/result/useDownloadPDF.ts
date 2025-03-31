import { useMutation } from "@tanstack/react-query";
import { postDownloadPDF } from "../../services/apiDownloadPDF";
import toast from "react-hot-toast";

export function useDownloadPDF() {
  const { mutate: downloadPDF, isPending: isDownloading } = useMutation({
    mutationFn: postDownloadPDF,
    onSuccess: () => {
      toast.success("ダウンロードが完了しました");
    },
    onError: (error: Error) => {
      const errorMessage = error.message || "ダウンロードに失敗しました";
      toast.error(errorMessage);
    },
  });

  return { downloadPDF, isDownloading };
}
