import { useMutation } from "@tanstack/react-query";
import toast from "react-hot-toast";
import { postFeedback as postFeedbackApi } from "../../services/apiFeedback";

export function usePostFeedback() {
  const { isPending: isPosting, mutate: postFeedback } = useMutation({
    mutationFn: postFeedbackApi,
    onSuccess: () => {
      toast.success("フィードバックを送信しました");
    },
    onError: (error: Error) => {
      const errorMessage =
        error.message || "フィードバックの送信に失敗しました。";
      toast.error(errorMessage);
    },
  });

  return { isPosting, postFeedback };
}
