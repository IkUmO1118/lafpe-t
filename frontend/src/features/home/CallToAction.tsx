import { useNavigate } from "react-router-dom";
import { Button } from "../../components/Button";

interface HeroProps {
  scrollToEvaluation: () => void;
}

function CallToAction({ scrollToEvaluation }: HeroProps) {
  const navigate = useNavigate();
  return (
    <section className="relative mb-14 h-[370px] w-full">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 1440 370"
        className="absolute top-0 left-0 h-full w-full"
        preserveAspectRatio="none"
      >
        <path
          d="M 0 310 Q 720 430 1440 310 L 1440 0 L 0 0 Z"
          fill="#104e64"
        ></path>
      </svg>

      <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 transform text-center text-neutral-50">
        <div className="mb-7 text-5xl font-bold">
          施設の最適解を、簡単に診断
        </div>
        <div className="flex items-center justify-center gap-4">
          <Button
            variant="fillWhite"
            size="lg"
            onClick={() => navigate("/diagnosis")}
          >
            診断を開始
          </Button>
          <Button variant="outlineWhite" size="lg" onClick={scrollToEvaluation}>
            ツールについて
          </Button>
        </div>
      </div>
    </section>
  );
}

export default CallToAction;
