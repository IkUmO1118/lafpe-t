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

    const responseText = await response.text();

    if (!response.ok) {
      const errorData = JSON.parse(responseText);
      throw new Error(errorData.message);
    }

    const result = JSON.parse(responseText);
    return result;
  } catch (error) {
    console.error("Failed to post feedback:", error);
    throw new Error(
      error instanceof Error ? error.message : "Failed to post feedback",
    );
  }
}
