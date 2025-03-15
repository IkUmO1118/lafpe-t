import { useState } from "react";
import { Button } from "../../components/Button";
import { usePostFeedback } from "./usePostFeedback";
import SpinnerMini from "../../components/SpinnerMini";

function FeedbackForm() {
  const [message, setMessage] = useState("");
  const { isPosting, postFeedback } = usePostFeedback();

  const handleSubmit = () => {
    if (!message.trim()) return;

    postFeedback(message, {
      onSuccess: () => {
        setMessage("");
      },
    });
  };

  return (
    <div className="flex h-full flex-col gap-9 px-24">
      <div className="relative mt-3 flex flex-col">
        <h1 className="text-base text-neutral-800">ご意見・感想など</h1>
        <div className="mt-3 w-full border-b-2 border-neutral-300"></div>
        <div className="absolute bottom-0 left-0 w-32 border-b-2 border-cyan-800"></div>
      </div>

      <form className="group relative min-h-[450px] flex-1">
        <label
          htmlFor="feedback"
          className="absolute -top-2 left-4 z-10 bg-neutral-50 px-0.5 text-xs text-neutral-600 transition-colors duration-200 group-focus-within:text-cyan-700"
        >
          ご意見や感想を入力してください*
        </label>
        <textarea
          name="feedback"
          id="feedback"
          className="h-full w-full rounded-md border border-neutral-500 p-4 transition-all focus:border-cyan-800 focus:ring-2 focus:ring-cyan-800 focus:outline-none"
          placeholder="例: 原則1の数値がイメージと異なった印象を受けた。"
          required
          onChange={(e) => setMessage(e.target.value)}
          value={message}
        ></textarea>
      </form>

      <Button
        variant="fillPrimary"
        size="wide"
        disabled={isPosting}
        onClick={handleSubmit}
      >
        {isPosting ? <SpinnerMini /> : "送信する"}
      </Button>
    </div>
  );
}

export default FeedbackForm;
