import { useMutation } from "@tanstack/react-query";
import toast from "react-hot-toast";
import { postFeedback as postFeedbackApi } from "../../services/apiFeedback";

export function usePostFeedback() {
  const { isPending: isPosting, mutate: postFeedback } = useMutation({
    mutationFn: postFeedbackApi,
    onSuccess: () => {
      toast.success("フィードバックを送信しました");
    },
    onError: (err) => toast.error(err.message),
  });

  return { isPosting, postFeedback };
}
