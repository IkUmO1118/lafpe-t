import Button from "../../components/Button";

interface HeroProps {
  scrollToEvaluation: () => void;
}

function Hero({ scrollToEvaluation }: HeroProps) {
  return (
    <div className="flex flex-col items-center justify-center gap-10 pt-20 pb-16">
      <h1 className="text-5xl font-bold text-cyan-950">
        実験動物施設性能診断ツールで
        <br />
        施設の性能を評価し、最適化する
      </h1>
      <div className="flex gap-4">
        <Button
          as="button"
          type="fill"
          color="primary"
          className="rounded-sm px-6 py-4 text-base font-bold"
        >
          診断を開始する
        </Button>
        <Button
          as="button"
          type="outline"
          color="primary"
          className="rounded-sm px-6 py-4 text-base font-medium"
          onClick={scrollToEvaluation}
        >
          ツールについて
        </Button>
      </div>
    </div>
  );
}

export default Hero;
