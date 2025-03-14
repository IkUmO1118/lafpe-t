import { useNavigate } from "react-router-dom";
import { Button } from "../../components/Button";

interface HeroProps {
  scrollToEvaluation: () => void;
}

function Hero({ scrollToEvaluation }: HeroProps) {
  const navigate = useNavigate();

  return (
    <div className="flex flex-col items-center justify-center gap-10 pt-20 pb-16">
      <h1 className="text-5xl font-bold text-cyan-950">
        実験動物施設性能診断ツールで
        <br />
        施設の性能を評価し、最適化する
      </h1>
      <div className="flex gap-4">
        <Button
          variant="fillPrimary"
          size="base"
          onClick={() => navigate("/diagnosis")}
        >
          診断を開始する
        </Button>
        <Button
          variant="outlinePrimary"
          size="base"
          onClick={scrollToEvaluation}
        >
          ツールについて
        </Button>
      </div>
    </div>
  );
}

export default Hero;
