import Button from "../../components/Button";

function CallToAction() {
  return (
    <div className="flex flex-col items-center gap-8 overflow-hidden bg-cyan-900 py-28">
      <div className="text-5xl font-bold text-neutral-50">
        施設の最適解を、簡単に診断
      </div>
      <div className="flex items-center justify-center gap-2">
        <Button
          as="button"
          type="fill"
          color="white"
          className="rounded-sm px-10 py-4 text-sm font-medium"
        >
          診断を開始
        </Button>
        <Button
          as="button"
          type="outline"
          color="white"
          className="rounded-sm px-10 py-4 text-sm font-medium"
        >
          ツールについて
        </Button>
      </div>
    </div>
  );
}

export default CallToAction;
