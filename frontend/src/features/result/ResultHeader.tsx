import { useRef } from "react";
import html2canvas from "html2canvas";
import PrincipleRadarChart from "../../components/Charts";
import { Button } from "../../components/Button";
import { ScoresState } from "../../types/diagnosis";
import { useDownloadPDF } from "./useDownloadPDF";
import SpinnerMini from "../../components/SpinnerMini";
import { PrincipleProps } from "../../types/principle";

interface ResultHeaderProps {
  answersData: ScoresState;
  kartesData: PrincipleProps;
  scrollToContent: () => void;
}

function ResultHeader({
  answersData,
  kartesData,
  scrollToContent,
}: ResultHeaderProps) {
  const chartRef = useRef<HTMLDivElement>(null);
  const { downloadPDF, isDownloading } = useDownloadPDF();

  async function handleDownloadPDF() {
    try {
      if (!chartRef.current) return;

      const canvas = await html2canvas(chartRef.current, {
        scale: 2,
        backgroundColor: "#ffffff",
        logging: false,
      });
      const chartImage = canvas.toDataURL("image/jpeg", 0.95);

      downloadPDF(
        { questionAnswers: answersData, chartImage },
        {
          onSuccess: async (response) => {
            // Blobを作成してダウンロード処理
            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);
            const link = document.createElement("a");
            link.href = url;
            link.setAttribute("download", "実験動物施設性能診断結果.pdf");
            document.body.appendChild(link);
            link.click();

            window.URL.revokeObjectURL(url);
            document.body.removeChild(link);
          },
          onError: (error) => {
            alert(
              `PDFの生成に失敗しました。もう一度お試しください。: ${error}`,
            );
          },
        },
      );
    } catch (error) {
      alert(`PDFの生成に失敗しました。もう一度お試しください。: ${error}`);
    }
  }

  return (
    <div className="flex w-3/5 flex-col items-center gap-8 self-center pt-20 pb-14">
      <h1 className="text-5xl font-black text-neutral-900">
        施設性能の診断結果
      </h1>
      <div className="relative flex h-96 w-full justify-between">
        <div className="opacity-0">hidden</div>
        <div
          ref={chartRef}
          className="absolute top-0 h-96 w-full justify-self-center"
        >
          <PrincipleRadarChart
            principle1={kartesData.principle1}
            principle2={kartesData.principle2}
            principle3={kartesData.principle3}
            principle4={kartesData.principle4}
            principle5={kartesData.principle5}
            dp={kartesData.principleDP}
          />
        </div>
        <div className="z-50 flex flex-col justify-end gap-5">
          <Button
            variant="fillPrimary"
            size="base"
            disabled={isDownloading}
            onClick={handleDownloadPDF}
          >
            {isDownloading ? (
              <SpinnerMini message="ダウンロード..." />
            ) : (
              "結果をPDFで保存"
            )}
          </Button>
          <Button
            variant="outlinePrimary"
            size="base"
            onClick={scrollToContent}
          >
            回答内容を確認する
          </Button>
        </div>
      </div>
    </div>
  );
}

export default ResultHeader;
