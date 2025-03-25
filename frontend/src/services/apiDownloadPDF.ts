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
    const response = await fetch(
      `/api/download/pdf`,
      // `${import.meta.env.VITE_DEV_API_URL}/api/download/pdf`,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ questionAnswers, chartImage }),
      },
    );

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    return response;
  } catch (error) {
    console.error("Failed to post feedback:", error);
    throw new Error(
      error instanceof Error ? error.message : "Failed to post feedback",
    );
  }
}
