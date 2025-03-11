import {
  Radar,
  RadarChart,
  PolarGrid,
  PolarAngleAxis,
  ResponsiveContainer,
  Legend,
  PolarRadiusAxis,
} from "recharts";
import { TickItem } from "recharts/types/util/types";

// カスタム四角形マーカーコンポーネント
const renderSquareShape = (props) => {
  const { cx, cy } = props;

  return <rect x={cx - 4} y={cy - 4} width={8} height={8} fill="#0e7490" />;
};

// プロップスの型定義
interface PrincipleRadarChartProps {
  principle1?: number;
  principle2?: number;
  principle3?: number;
  principle4?: number;
  principle5?: number;
  dp?: number;
}

const PrincipleRadarChart = ({
  principle1,
  principle2,
  principle3,
  principle4,
  principle5,
  dp,
}: PrincipleRadarChartProps) => {
  // 修正したデータ - 基準値を全て5に統一、評価結果も10を最大とする範囲で調整
  const data = [
    { principle: "原則1", 評価結果: principle1, 基準値: 5 },
    { principle: "原則2", 評価結果: principle2, 基準値: 5 },
    { principle: "原則3", 評価結果: principle3, 基準値: 5 },
    { principle: "原則4", 評価結果: principle4, 基準値: 5 },
    { principle: "原則5", 評価結果: principle5, 基準値: 5 },
    { principle: "DP", 評価結果: dp, 基準値: 5 },
  ];

  const customTicks: TickItem[] = [0, 2, 4, 6, 8, 10];

  return (
    <div className="flex h-96 w-full flex-col items-center">
      <h2 className="mb-4 text-xl font-bold">原則評価チャート</h2>
      <ResponsiveContainer width="100%" height="100%">
        <RadarChart cx="50%" cy="50%" outerRadius="70%" data={data}>
          <PolarGrid gridType="polygon" />
          <PolarAngleAxis dataKey="principle" />

          <PolarRadiusAxis
            domain={[0, 10]}
            ticks={customTicks}
            tick={{ fontSize: 0 }}
            axisLine={false}
            tickLine={false}
          />

          <Radar
            name="評価結果"
            dataKey="評価結果"
            stroke="#0e7490"
            strokeWidth={3}
            fillOpacity={0}
            dot={renderSquareShape}
          />

          <Radar
            name="基準値"
            dataKey="基準値"
            stroke="#f97316"
            strokeWidth={2.5}
            fillOpacity={0}
            dot={false}
          />

          <Legend />
        </RadarChart>
      </ResponsiveContainer>
    </div>
  );
};

export default PrincipleRadarChart;
