import { useMutation } from "@tanstack/react-query";
import { postDownloadPDF } from "../../services/apiDownloadPDF";
import toast from "react-hot-toast";

export function useDownloadPDF() {
  const { mutate: downloadPDF, isPending: isDownloading } = useMutation({
    mutationFn: postDownloadPDF,
    onSuccess: () => {
      toast.success("ダウンロードが完了しました");
    },
    onError: () => {
      toast.error("ダウンロードに失敗しました");
    },
  });

  return { downloadPDF, isDownloading };
}
