export type AuthorityStatus =
  | "established"
  | "working"
  | "proposed"
  | "unresolved"
  | "rejected";

export type WorkflowPhase =
  | "scope"
  | "retrieve"
  | "analyze"
  | "develop"
  | "evaluate"
  | "author_gate"
  | "integrate"
  | "complete"
  | "blocked";

export interface SourceRef {
  path: string;
  heading?: string;
  status?: AuthorityStatus;
  checksum?: string;
}

export interface AuthorityGate {
  id: string;
  prompt: string;
  state: "waiting" | "accepted" | "rejected";
  acceptedValue?: string;
  decidedAt?: string;
}

export interface WorkflowState {
  workflowId: string;
  taskId: string;
  depth: string;
  phase: WorkflowPhase;
  updatedAt: string;
  sources: SourceRef[];
  gate?: AuthorityGate;
}

export interface ProjectManifest {
  formatVersion: string;
  projectId: string;
  title: string;
  defaultProvider: string;
  defaultModel: string;
  paths: {
    context: string;
    story: string;
    workflow: string;
    qa: string;
    artifacts: string;
  };
}

export interface ModelRequest {
  requestId: string;
  purpose: "analysis" | "alternatives" | "prototype" | "evaluation";
  system: string;
  prompt: string;
  sources: SourceRef[];
  outputSchema?: Record<string, unknown>;
}

export interface ModelResponse {
  requestId: string;
  provider: string;
  model: string;
  createdAt: string;
  content: string;
  sourceChecksums: string[];
}

export interface ModelProvider {
  id: string;
  health(): Promise<{ available: boolean; models: string[] }>;
  generate(request: ModelRequest): Promise<ModelResponse>;
}
