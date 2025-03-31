import { ScoresState } from "../types/diagnosis";

interface postDownloadPDFProps {
  questionAnswers: ScoresState;
  chartImage: string;
}

export async function postDownloadPDF({
  questionAnswers,
  chartImage,
}: postDownloadPDFProps) {
  try {
    const response = await fetch(`/api/download/pdf`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ questionAnswers, chartImage }),
    });

    if (!response.ok) {
      // エラーの場合のみレスポンスをテキストとして取得
      const responseText = await response.text();

      try {
        // JSONとしてパースを試みる
        const errorData = JSON.parse(responseText);
        throw new Error(
          errorData.message || `エラーが発生しました: ${response.status}`,
        );
      } catch {
        // JSONパースに失敗した場合はレスポンスのテキストをそのまま使用
        throw new Error(`エラーが発生しました: ${response.status}`);
      }
    }

    return response;
  } catch (error) {
    console.error("Failed to post feedback:", error);
    throw new Error(
      error instanceof Error ? error.message : "Failed to post feedback",
    );
  }
}
